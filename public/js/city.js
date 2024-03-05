
$(document).ready(function($) {

    $('.js-example-basic-single').select2();

    var countryId;
    $('#country').change(function () {
        $('#state').empty();
        $('#city').empty();
        countryId = $(this).val();
        if(countryId!='') {
            $.get('/get-state/'+countryId, function (data) {
                $('#state').empty();
                $('#state').empty().append('<option value="">Seleccionar...</option>');

                $.each(data, function (key, value) {
                    $('#state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
                });
            });
        }
    });


    $('#state').change(function () {

        var stateId = $(this).val();
        if(countryId!='' && stateId!='') {
            $.get('/get-city/'+countryId+'/'+stateId, function (data) {
                $('#city').empty();
                $('#city').empty().append('<option value="">Seleccionar...</option>');

                $.each(data, function (key, value) {
                    $('#city').append('<option value="' + value.name + '">' + value.name + '</option>');
                });
            });
        }
    });


    $('#city').change(function () {
        var cityName = $(this).val();
        $("#miTextarea").val("");
        if(cityName!=='' ) {


            $.get('/getinfo-city/'+cityName+'/'+countryId)
                .done(function (data) {
                    if (data.length > 0 ) {
                        console.log(data)
                        var jsonData = JSON.parse(data);
                        var cityData = jsonData[0];
                        if (cityData) {
                            $("#miTextarea").val(JSON.stringify(cityData));
                        } else {
                            $("#miTextarea").val("");
                        }
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // Maneja el error
                    console.log("Error: " + textStatus + ": " + errorThrown);
                });

            }
    });

    $('#addcity').click(function() {


        let selectedCity = document.querySelector('#city').value;
        if(selectedCity!=='' ) {
            let url = '/info-city'
            let form = document.querySelector('#addFormCity');


            let data = new FormData(form);
            data.append('city', selectedCity);
            axios.post(url, data).then((res) => {
                if (!res.data.err) {
                    form.reset()
                    $("#country").val('').change();
                    alert('Ciudad guardada')

                } else {
                    alert(res.data.err)
                }
            })
        }
    });



});
