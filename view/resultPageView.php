<?php
class resultPageView{
    public function htmlView()
    {
        return 'template/result.php';
    }

    public function run($dataType='html')
    {
        //for now render only html template in this view
        return $this->htmlView();
    }
}