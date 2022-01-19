<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\TestJob;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;
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
        print_r($email . " Sended For Password reset");
        /* echo " [x] Sent 'Hello World!'\n"; */
        /* TestJob::dispatch($request->post("email")); */
    }

    public function postLogin(LoginRequest $request)
    {
        $email = $request->post("email");
        $password = $request->post("password");
        $users = DB::table('users')->get()->all();
            foreach ($users as $user) {
                if ($user->email == $email||$user->password ==$password) {
                    $checkedUser = $user;
                }
            }
        if ($checkedUser==null) {
            /* return redirect("/login")->withInput(); */
        }

        print_r("<h1 style='color:green;'>Login Success</h1>" . $checkedUser->name . "<br><br><a href='/'>Return to Main Page</a>");
    }

    public function postRegister(RegisterRequest $request)
    {
        UserModel::insert(["name" => $request->post("name"), "email" => $request->post("email"), "password" => $request->post("password")]);
    }




    private function sendEmail($subject, $email, $message = null, $resetPassword = false)
    {

        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('default', false, true, false, false);
        if ($resetPassword == true) {
            $newPassword = Str::random(8) . random_int(0, 99);
            $users = DB::table('users')->get()->all();
            foreach ($users as $user) {
                if ($user->email == $email) {
                    $checkedUser = $user;
                }
            }

            $msg = new AMQPMessage($subject . "\n" . $email . "\nNew Password: " . $newPassword . "\n" . $message);
            DB::update('update users set password=? where id = ?', [$newPassword,$checkedUser->id]);
        } else {
            $msg = new AMQPMessage($subject . "\n" . $email . "\n" . $message);
        }


        $channel->basic_publish($msg, '', 'default');
        $channel->close();
        $connection->close();
    }
}
