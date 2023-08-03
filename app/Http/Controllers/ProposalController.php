<?php

namespace App\Http\Controllers;

use App\Models\Dao;
use App\Models\Proposal;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('proposal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($dao_id)
    {
        $dao = Dao::findOrFail($dao_id);
        return view('proposal.create', compact('dao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($dao_id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'about' => 'required',
            'start_date' => 'required|date'
        ]);
        $request['dao_id'] = $dao_id;

        $startDate = new DateTime($request->start_date);

        // Add 10 days to the start date
        $startDate->add(new DateInterval('P10D'));

        $request['end_date'] = $startDate->format('Y-m-d');

        Proposal::create($request->all());
        return redirect()->route('dao', $dao_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
