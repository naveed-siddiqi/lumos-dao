<?php

namespace App\Http\Controllers;

use App\Models\Staking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AppController extends Controller
{
    public function home()
    {
        // $view = isset($_COOKIE['public']) ? 'index' : 'guest';
        // temporary
        $view = Route::currentRouteName()=='explore' ? 'index' : 'guest';

        return view($view);
    }
    public function invest()
    {
        return view('invest');
    }
    public function contact(Request $request)
    {
        $email = $request->email;
        $name = $request->name;
        $message = $request->message;

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Name is empty';
        }

        if (empty($email)) {
            $errors[] = 'Email is empty';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is invalid';
        }

        if (empty($message)) {
            $errors[] = 'Message is empty';
        }

        if ($errors) {
            return response()->json(['status' => 0, 'errors' => $errors]);
        }

        $toEmail = 'info@answerly.app';
        $emailSubject = 'Email from Answerly Staking';
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

        $bodyParagraphs = ["<h3>Email from Answerly Staking</h3>","Name: {$name}<br>", "Email: {$email}<br>", "Message:", $message];
        $body = join(PHP_EOL, $bodyParagraphs);

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            return response()->json(['status' => 1, 'msg' => ['Message Successfully sended!']]);
        } else {
            return response()->json(['status' => 0, 'errors' => ['Something went wrong!']]);
        }
    }

    public function stakers(Request $request)
    {
        if($request->has('search')){
            $stakers = Staking::where('public',$request->search)->get();
        }else{
            $stakers = Staking::all();
        }
        $totalStake=Staking::sum('amount');
        return view('stakers',compact('stakers','totalStake'));
    }
}
