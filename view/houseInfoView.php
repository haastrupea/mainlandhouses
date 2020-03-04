<?php
class houseInfoView{
    public function htmlView()
    {
        return 'template/house-info.php';
    }

    public function run($dataType='html')
    {
        //for now render only html template in this view
        return $this->htmlView();
    }
}