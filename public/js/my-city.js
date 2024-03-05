
$(document).ready(function($) {

    $(document).on('click','#delete', function () {
        var cityId = $(this).closest('tr').find('th:first').text();

        let url =  "/info-city/"+cityId;
        axios.delete(url).then((res) => {
            if(!res.data.err){
                alert('Ciudad eliminada');
                $(this).closest('tr').remove();
            }else{
                alert(res.data.err);
            }
        });

    });

});
