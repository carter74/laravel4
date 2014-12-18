<?

class JobsController extends BaseController
{

public function getJob($id){

    $job = job::where('id', '=', $id)->firstOrFail();
    return View::make('job.showjobs')->with('job', $job);

}


}