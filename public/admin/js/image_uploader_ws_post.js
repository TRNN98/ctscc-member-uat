$(document).ready(function(){

    const ArrayListImg = Array();

    $('.input-images-2').imageUploader({
        imagesInputName: 'photos',
        preloadedInputName: 'old'
    });

    $('input[name="photos[]"]').change(function(event){

        $('input[name="fileRemove[]"]').val('');

        var files = event.target.files;  
        

        for( var i=0 ; i < files.length ; i++)
        {

            ArrayListImg.push(files[i]);
            
        }

        removeFileList();

    });

    function removeFileList()
    {
        var removeArrByNameImg = [];
        $('.delete-image').click(function(event){
            var index = $(this).parent().data('index');
            var files = $('input[name="photos[]"]').prop('files');

            //send name files to delete
            removeArrByNameImg.push(files[index].name);
            $('input[name="fileRemove[]"]').val(removeArrByNameImg);
        });  

    }

});