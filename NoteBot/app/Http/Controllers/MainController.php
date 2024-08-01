<?php

namespace App\Http\Controllers;

use App\Models\BooksModel;
use App\Models\ContentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect()->route('/')->with('success', 'You have been logout.');
    }

    public function login_signup()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        $data['title'] = 'Login/Signup';
        return view('index', $data);
    }

    public function introduction()
    {
        $data['title'] = 'Introduction';
        return view('introduction', $data);
    }

    public function delete(Request $request)
    {
        $data['book_id'] = base64_decode($request->book);
        BooksModel::where('id', $data['book_id'])->delete();
        return redirect()->back()->with('success', 'Book has been deleted.');
    }
    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $data['back_link'] = route('/');
        $data['nav_title'] = 'My Notes';
        $data['books'] = BooksModel::where('user_id', Auth::id())->latest()->get();
        return view('dashboard', $data);
    }

    public function view(Request $request)
    {
        $data['book_id'] = base64_decode($request->book);
        $data['book'] = BooksModel::with('content')->where('id', $data['book_id'])->first();
        $data['back_link'] = route('dashboard');
        $data['nav_title'] = $data['book']->name;
        $data['image'] = $data['book']->image;
        return view('viewBook', $data);
    }
    public function share(Request $request)
    {
        $data['book_id'] = base64_decode($request->book);
        $data['book'] = BooksModel::with('content')->where('id', $data['book_id'])->first();
        $data['back_link'] = route('dashboard');
        $data['nav_title'] = $data['book']->name;
        $data['image'] = $data['book']->image;
        return view('shareBook', $data);
    }

    public function naveed(Request $request){


        $data['naveed_name'] = 'Naveed Khan';
        $data['dsdsds'] = 'Nave1n';
        $data['vddvc'] = 'N2Khan';
        $data['sfds'] = 'Na3han';


        return view('naveed', $data);
    }




    public function save_audio(Request $request)
    {
        $audio = '';
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioName = time() . '-' . $audio->getClientOriginalName() . '.ogg';
            $audio->move(public_path('uploads/audio'), $audioName);
            $audio = 'uploads/audio/' . $audioName;
        }
        if ($audio) {
            
            $content = ContentModel::where('id', $request->content)->first();
            $html = '<br><audio controls>
                        <source src="' . $audio . '" type="audio/ogg">
                        Your browser does not support the audio element.
                    </audio>';
            $new_html = $content->content . $html;
            return response()->json(['html' => $new_html]);
        }
    }




    public function save_book(Request $request)
    {
        $book_id = base64_decode($request->book);
        $content = $request->content;
        $contentModel = ContentModel::where('book_id', $book_id)->first();
        if ($contentModel) {
            $contentModel->update(['content' => $content]);
        } else {
            ContentModel::create([
                'book_id' => $book_id,
                'content' => $content
            ]);
        }
        return response()->json(true);
    }

    public function add_new_book(Request $request)
    {
        if ($request->hasFile('book_image')) {
            $book_image = $request->file('book_image');
            $book_imageName = time() . '-' . $book_image->getClientOriginalName();
            $book_image->move(public_path('uploads/books'), $book_imageName);
            $book_image = 'uploads/books/' . $book_imageName;
        }
        $book = BooksModel::create([
            'user_id' => Auth::id(),
            'name' => $request->book_name,
            'image' => isset($book_image) ? $book_image : '',
        ]);
        ContentModel::create([
            'book_id' => $book->id,
            'content' => ''
        ]);
        return redirect()->route('dashboard')->with('success', 'Book has been added.');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'phonenumber' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = new User();
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login_signup')->with('success', 'Registration successful!');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }
    }
}
