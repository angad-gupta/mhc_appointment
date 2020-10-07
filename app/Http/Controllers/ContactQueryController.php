<?php

namespace App\Http\Controllers;

use App\Mail\WebContactMail;
use App\Models\Contact;
use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactQueryController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin.only')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_queries = ContactQuery::where('contact_query_id', null)->orderBy('checked', 'asc')->paginate(20);

        return view('operations.contact-query.index', [
            'contact_queries' => $contact_queries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.contact-query.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email_address' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $contact_query = new ContactQuery();

        $contact_query->fill($request->all());
        if ($contact_query->save()) {
            $this->sendMail($contact_query);
            return redirect()->route('success', 'title=Mail has been send&message=Our support team will contact you very soon.');
        }
    }

    private function sendMail($contact_query)
    {
        $contact = Contact::first();
        if (config('installer.steps.mail') == 1 && is_object($contact)) {
            if ($contact->mail != null) {
                try {
                    Mail::to($contact->mail)->send(new WebContactMail($contact_query));
                } catch (\Exception $exception) {

                }
            }

        }


    }

    /**
     * Store mail reply
     *
     * @param Request $request
     */
    public function reply(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact_query = ContactQuery::findOrFail($id);
        $contact_query->checked = true;
        $contact_query->save();
        return view('operations.contact-query.show', [
            'contact_query' => $contact_query
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('operations.contact-query.edit', [
            'contact_query' => ContactQuery::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $old_query = ContactQuery::findOrFail($id);

        $contact_query = new ContactQuery();
        $contact_query->email_address = $old_query->email_address;
        $contact_query->full_name = 'Admin';
        $contact_query->fill($request->all());
        $contact_query->checked = true;
        $contact_query->contact_query_id = $old_query->id;
        if ($contact_query->save()) {
            if (config('installer.steps.mail') == 1) {
                try {
                    Mail::to($contact_query->email_address)->send(new WebContactMail($contact_query));
                    return redirect()->back()->with('success', 'mail has been send');
                } catch (\Exception $exception) {
                    return redirect()->back()->with('error', $exception->getMessage());
                }
            }
            return redirect()->back()->with('error', 'System cannot send mail');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ContactQuery::destroy($id)) {
            return redirect()->route('contact-query.index')->with('success', 'Mail has been deleted successfully');
        }
    }
}
