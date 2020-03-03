<?php  
 if($_FILES['uploadFile']['name'] != '')  
 {  

 	$file_extension = strtolower(pathinfo($_FILES["uploadFile"]["name"], PATHINFO_EXTENSION));
	$new_file_name = rand() . '.' . $file_extension;
	$source_path = $_FILES["uploadFile"]["tmp_name"];
	$target_path = 'data/posting/temp/' . $_FILES["uploadFile"]["name"];
	if(move_uploaded_file($source_path, $target_path))
	{
		if($file_extension == 'jpg' || $file_extension == 'png')
		{
			echo '
			<div class="card" style="margin-bottom: 0px;">
                <div class="el-card-item" style="padding-bottom: 0px;">
                    <div class="el-card-avatar el-overlay-1" style="margin-bottom: 0px;"> <img src="'.$target_path.'" alt="user" />
                        <div class="el-overlay">
                            <ul class="el-info">
                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="javascript:void(0);" for="uploadFile"><label for="uploadFile" style="margin-bottom: 0px;"><i class="icon-magnifier"></i></label></a></li>
                                <li><a class="btn default btn-outline" href="javascript:void(0);" data-path="'.$target_path.'" id="remove_button"><i class="icon-trash"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            ';
		}

		if($file_extension == 'mp4')
		{
			echo '
			<div class="embed-responsive embed-responsive-16by9">
				<video class="embed-responsive-item" controls="controls" src="'.$target_path.'"></video>
			</div>
			<br />
			';
		}
	}  
    else  
    {  
        echo '<script>alert("Invalid File Formate")</script>';  
    }  
}  
else  
{  
    echo '<script>alert("Please Select File")</script>';  
}  
?> 