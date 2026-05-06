<?php

namespace App\Http\Controllers;

use App\Models\Contact;
// use App\Models\Setteing;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //   $setting=Setteing::Selection()->first();
    //    return view('Front.pages.contact',compact('setting'));
    // }

    /**
     * Show the form for creating a new resource.
     */
     public function index()
    {
        $contacts = Contact::all();
        return view('dashboard.complaint.index', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Contact::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'message'=>$request->message,

        ]);
      return redirect('/')->with('success', 'Contact Create successfully!');
}

    public function destroy(string $id)
    {
          Contact::findOrFail($id)->delete();
        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully!');
    }
    public function destroyAll()
{
    Contact::truncate();
    return redirect()->route('contacts.index')
        ->with('success', 'All contacts deleted successfully!');
}

}
