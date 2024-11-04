$(document).ready(function(){
    
    $('.image-uploader').on('dragenter',function(e){

        e.preventDefault();
        $(this).css({'border':'4px dashed #ffb38d'});
        console.log('enter');

    });

    let dataTransfer = new DataTransfer();

    $('input[name="photos[]"]').change(function(event){

        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(', ')); 
            return false;
        }
        
        var files = event.target.files;

        //push array in dataTranfer file
        $.each(files,function(i,file){
            dataTransfer.items.add(file);
        });

        
        deleteNewImg();
    });

    
    $('.delete-image').click(function(){

        //get No and Seq (table www_data_img)
        let NoandSeq = $(this).next('input[name="old[]"]').val().split('_');
        let No = NoandSeq[0];
        let Seq = NoandSeq[1];

        $.ajax({
            url:"/delete_img",
            method:'POST',
            data:{No:No,Seq:Seq},
            success:function(data){
                Lobibox.notify("success", {
                    msg: "ลบข้อมูลสำเร็จ"
                });
            }
        });

    });

    function deleteNewImg()
    {
        
        $('.delete-image').click(function(){
            
            var ind = $(this).next().val();

            $.each($('.uploaded .uploaded-image'),function(x,v){
                
                $('.uploaded .uploaded-image').eq(x).attr('data-index',x);
                console.log(x,v);
            });

            //remove object filelist in dataTranfer
            dataTransfer.items.remove(ind);

            //update dataTranfer in element
            $('input[name="photos[]"]').prop('files', dataTransfer.files);

        });
    }


});

