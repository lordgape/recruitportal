<?php

namespace App\Http\Controllers;

use App\job;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // We only allow 4 entries
        $joball = Job::all();

        if(count($joball) >= 4 )
        {
            return response(["error" => "Application Closed"],Response::HTTP_BAD_REQUEST);
        }



        // Validate user input
        $this->validate($request,[

                "first_name" => "required",
                "surname" => "required",
                "phone" => "required|numeric",
                "email" => "required",
                "cover_letter" => "required",
                "passport" => "required|image|nullable|max:1999",
                "resume" => "required|nullable|max:1999"
            ]);


        // dynamically get filename and extension for both photo and resume

        $passportNameToStore = "";
        $fileNameToStore = "";



        if($request->hasFile("passport"))
        {
            $fileNameWithExt = $request->file("passport")->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

            $fileExtension = $request->file("passport")->getClientOriginalExtension();

            $passportNameToStore = $fileName . "_". time(). "." . $fileExtension ;

            //upload Image
            $path = $request->file("passport")->storeAs("public/passports",$passportNameToStore);

        }
        else
        {
            $passportNameToStore = "noimage.jpg" ;
        }


        if($request->hasFile("resume"))
        {
            $fileNameWithExt = $request->file("resume")->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

            $fileExtension = $request->file("resume")->getClientOriginalExtension();

            $fileNameToStore = $fileName . "_". time(). "." . $fileExtension ;

            //upload docx
            $path = $request->file("resume")->storeAs("public/resumes",$fileNameToStore);

        }
        else
        {
            $fileNameToStore = "noresume.jpg" ;
        }

        $job =  Job::create([
            'first_name' => $request->input('first_name'),
            'surname' => $request->input('surname'),
            'applicant_email' => $request->input('email'),
            'cover_letter' => $request->input('cover_letter'),
            'phone' => $request->input('phone'),
            'passport' => $passportNameToStore,
            'resume' => $fileNameToStore
        ]);



        return response(["data" => "Job application was successful"],Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(job $job)
    {
        //
    }
}
