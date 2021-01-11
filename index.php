<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>test</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
    <style type="text/css">
        div.sortable { width: 100px; font-size: large;
            float: left; margin: 6px; text-align: center; border: medium solid black;
            padding: 10px;}
    </style>
    <script type="text/javascript">

        $(document).ready(function(){
            $('.reorder_link').on('click',function(){
                $("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
                $('.reorder_link').html('Сохранить порядок фото');
                $('.reorder_link').attr("id","saveReorder");
                $('#reorderHelper').slideDown('slow');
                $('.image_link').attr("href","javascript:void(0);");
                $('.image_link').css("cursor","move");

                $("#saveReorder").click(function( e ){
                    if( !$("#saveReorder i").length ){
                        $("ul.reorder-photos-list").sortable('destroy');
                        $("#reorderHelper").html("Сохранение...").removeClass('light_box').addClass('notice notice_error');

                        var h = [];
                        $("ul.reorder-photos-list li").each(function() {
                            h.push($(this).attr('id').substr(9));
                        });

                        $.ajax({
                            type: "POST",
                            url: "updateList.php",
                            data: {ids: " " + h + ""},
                            success: function(){
                                window.location.reload();
                            }
                        });
                        return false;
                    }
                    e.preventDefault();
                });
            });
        });
    </script>
</head>
<body>

<div class="container">
    <a href="javascript:void(0);" class="reorder_link" id="saveReorder">Нажмите для начала перемещения</a>
    <div id="reorderHelper" class="light_box" style="display:none;">1. Перемещайте фото.<br>2. Нажмите 'Сохранить порядок фото' когда закончите.</div>
    <div class="gallery">
        <ul class="reorder_ul reorder-photos-list">
            <?php
            // Include and create instance of DB class
            require_once 'connect.php';
            $db = new DB();

            // Fetch all images from database
            $images = $db->getRows();
            if(!empty($images)){
                foreach($images as $row){
                    ?>
                    <li id="image_li_<?php echo $row['id']; ?>" class="ui-sortable-handle">
                        <a href="javascript:void(0);" style="float:none;" class="image_link">
                            <img src="images/<?php echo $row['file_name']; ?>" width="100" height="100" alt="">
                        </a>
                    </li>
                <?php } } ?>
        </ul>
    </div>
</div>

</body>
</html></code>

