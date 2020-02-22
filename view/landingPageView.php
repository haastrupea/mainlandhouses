<?php
class landingPageView{

    public function htmlView()
    {
        return 'template/home.php';
    }

    public function run($dataType='html')
    {
        //for now render only html template in this view
        return $this->htmlView();
    }
}