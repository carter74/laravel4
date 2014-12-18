<?

class ApplsController extends BaseController
{

public function getAppl($id){

    $appl = appl::where('id', '=', $id)->firstOrFail();
    return View::make('appl.showappls')->with('appl', $appl);

}


}