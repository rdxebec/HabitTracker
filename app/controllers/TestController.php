<?php



class TestController extends Controller
{
    public function index()
    {
        $user = new User();

        echo "Database Connected Successfully";
    }
}
?>