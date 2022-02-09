<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\UserModel;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RequestController extends Controller
{
    public function forgotPassword()
    {
        /* $users= User::all();
        print_r($users->toJson());
        TestJob::dispatch($users->toArray()); */

        /* $users= DB::table("users");
        TestJob::dispatch($users->tags->toArray()); */
        return view("password-reset");
    }

    public function postForgotPassword(Request $request)
    {
        $email = $request->post("email");
        $this->sendEmail("Reset Your Password", $email, null, true);
        return redirect()->route("mainPage")->with('info', 'Email Sent');

        /* echo " [x] Sent 'Hello World!'\n"; */
        /* TestJob::dispatch($request->post("email")); */
    }

    public function resetPasswordWithLink($link)
    {
        // will fix here an isssue needs add hover
        $data = null;
        $data = DB::table('users')->get()->where("password_reset_link", $link)->toArray();

        if ($data == null || $data[0]->password_reset_expire_time < Carbon::now()) {
            return redirect()->route("mainPage")->with("error", "Link Expired Or Undefiend");
        }

        $checkedData = null;
        if ($data[0]->password_reset_expire_time > Carbon::now()) {
            $checkedData = $data;
        }

        return view("password-reset-with-link", ["user" => $checkedData[0], "link" => $link]);
    }

    public function postResetPasswordWithLink(Request $request)
    {
        $checkedUser = null;
        $email = $request->post("email");
        $dataset = DB::table('users')->get()->all();
        foreach ($dataset as $data) {
            if ($data->email == $email) {
                $checkedUser = $data;
            }
        }
        if (md5($checkedUser->email . $checkedUser->password_reset_expire_time) == $checkedUser->password_reset_link) {
            
            // expire time, password and change link
            $forExpiredDate = Carbon::now()->addMinutes(-1);
            $this->changePasswordLinkAndExpireTime($email,$forExpiredDate,$checkedUser->id);

            DB::update(
                'update users set password=? where id = ?',
                [$request->post("password"), $checkedUser->id]
            );

            return redirect()->route("mainPage")->with("message", "Password Changed Successfully");
        }
    }


    public function postLogin(LoginRequest $request)
    {
        $email = $request->post("email");
        $password = $request->post("password");
        $checkedUser = null;
        $users = DB::table('users')->get()->all();
        foreach ($users as $user) {
            if ($user->email == $email && $user->password == $password) {
                $checkedUser = $user;
            }
        }
        if ($checkedUser == null) {
            return redirect("/login")->withInput()->with("error", "Email or Password Wrong");
        }

        print_r("<h1 style='color:green;'>Login Success</h1>" . $checkedUser->name . "<br><br><a href='/'>Return to Main Page</a>");
    }

    public function postRegister(RegisterRequest $request)
    {
        //min IO
        UserModel::insert(
            [
                "name" => $request->post("name"),
                "email" => $request->post("email"),
                "password" => $request->post("password"),
                "password_reset_link" => md5($request->post("email") . $request->post("name")),
                "password_reset_expire_time" => new DateTime()
            ]
        );
        return redirect()->route("mainPage")->with("message", "Register Success");
    }



    private function sendEmail($subject, $email, $message = null, $resetPassword = false)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('default', false, true, false, false);
        if ($resetPassword == true) {
            $users = DB::table('users')->get()->all();
            $checkedUser = null;
            foreach ($users as $user) {
                if ($user->email == $email) {
                    $checkedUser = $user;
                }
            }
            if ($checkedUser != null) {
                $newExpireDate = Carbon::now()->addMinutes(5);
                $newPasswordLink = md5($checkedUser->email . $newExpireDate);
                $this->changePasswordLinkAndExpireTime($checkedUser->email,$newExpireDate,$checkedUser->id);
                $msg = new AMQPMessage(
                    $subject . "\n" . $email . "\nReset Password Link: http://localhost:8000/reset/password/link/" . $newPasswordLink
                        . "\n" . $message
                );
            }
        } else {
            $msg = new AMQPMessage($subject . "\n" . $email . "\n" . $message);
        }


        $channel->basic_publish($msg, '', 'default');
        $channel->close();
        $connection->close();
    }

    private function changePasswordLinkAndExpireTime($email, $newExpireTime, $userId)
    {
        $newPasswordLink = md5($email . $newExpireTime);
        DB::update('update users set password_reset_link=?, password_reset_expire_time=? where id = ?', [$newPasswordLink, $newExpireTime, $userId]);
    }
}
