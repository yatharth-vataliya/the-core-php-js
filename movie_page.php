<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <title>Movie Page</title>
    <style>
        .main_poster {

            background-image: url('https://www.themoviedb.org/t/p/w533_and_h300_bestv2/cjaOSjsjV6cl3uXdJqimktT880L.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            padding: 0px;
        }

        .poster_image {
        }
    </style>
</head>
<body>

<div class="container-fluid main_poster">
    <div class="poster_color">
        <div class="row m-0">
            <div class="col-md-4 py-4 mr-0 pr-0" style="max-width: 27%;">
                <img class="poster_image rounded shadow-lg"
                     src="https://www.themoviedb.org/t/p/w300_and_h450_bestv2/tK1zy5BsCt1J4OzoDicXmr0UTFH.jpg"
                     style="width: 300px; height:450px;">
            </div>
            <div class="col-md-6 mt-5 info_part">
                <h2>
                    <span id="original_title" style="font-width: 700;">
                    </span>
                    <h2><a href="#" id="play_trailer" style="text-decoration: none; color: white;">&blacktriangleright; Play Trailer</a></h2>
                </h2>
                <b>OverView</b>
                <h6 id="overview">

                </h6>
                <b>Popularity</b>
                <h6 id="popularity">

                </h6>
                <b>Release Date</b>
                <h6 id="release_date">

                </h6>
            </div>
        </div>
    </div>
</div>
<div id="" class="my-2" style="height: 315px; overflow-x: scroll;">
<ol id="cast_div" style="display: flex; position: relative; list-style: none; list-style-position: inside;">

</ol>
</div>


<!-- Modal -->
<div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tailerModalLabel">Trailer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body trailer-body">
                <iframe id="trailer_frame" width="750" height="524" src=""
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>

                </iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
<script>
    var params = new URLSearchParams(window.location.search);
    document.addEventListener('DOMContentLoaded', function () {
        if (params.has('movie_id')) {
            $.ajax({
                url: `https://api.themoviedb.org/3/movie/${params.get('movie_id')}?api_key=a0acb84bc12a6a187fbf5cf4431ea867`,
                type: 'GET',
            }).done((res) => {
                $(".main_poster").css('backgroundImage', `url(https://image.tmdb.org/t/p/original/${res.backdrop_path})`);
                $(".poster_image").attr('src', `https://image.tmdb.org/t/p/original/${res.poster_path}`);
                $("#original_title").html(res.original_title);
                $("#overview").html(res.overview);
                $("#popularity").html(res.popularity);
                $("#release_date").html(res.release_date);
                const colorThief = new ColorThief();
                const img = document.querySelector('.poster_image');
                img.crossOrigin = 'Anonymous';
                if (img.complete) {
                    const colors = colorThief.getColor(img, 10);
                    $(".info_part").css('color', `white`);
                    $(".poster_color").css('background', `linear-gradient(to bottom right, rgba(${colors[0]}%, ${colors[1]}%, ${colors[2]}%, 1.00), rgba(${colors[0]}%, ${colors[1]}%, ${colors[2]}%, 0.14)`);
                } else {
                    img.addEventListener('load', function () {
                        const colors = colorThief.getColor(img, 10);
                        $(".info_part").css('color', `white`);
                        $(".poster_color").css('background', `linear-gradient(to bottom right, rgba(${colors[0]}%, ${colors[1]}%, ${colors[2]}%, 1.00), rgba(${colors[0]}%, ${colors[1]}%, ${colors[2]}%, 0.14)`);
                    });
                }
            });
        }
        $("#play_trailer").click(function () {
            $.ajax({
                url: `https://api.themoviedb.org/3/movie/${params.get('movie_id')}/videos?api_key=a0acb84bc12a6a187fbf5cf4431ea867&language=en-US`,
                type: 'GET',
            }).done((res) => {
                if (res.results.length) {
                    $("#trailer_frame").attr('src', `https://www.youtube.com/embed/${res.results[0].key}?autoplay=1`);
                    $("#trailerModal").modal('show');
                } else {
                    $(".trailer-body").html(`<h1>Sorry There is no trailer for this movie is found</h1>`);
                    $("#trailerModal").modal('show');
                }
            });
        });

        $.ajax({
            url: `https://api.themoviedb.org/3/movie/${params.get('movie_id')}/credits?api_key=a0acb84bc12a6a187fbf5cf4431ea867&language=en-US`,
            type: 'GET',
        }).done((res) => {
            var html = '';
            var cast = res.cast;
            for (i = 0; i < cast.length; i++) {
                if (cast[i].profile_path != null) {
                    html += `<li >
                        <span class="rounded shadow text-center float-left text-break text-wrap p-0">
  <img src="https://image.tmdb.org/t/p/original/${cast[i].profile_path}" style="width: 138px; height:175px; background-size: cover; margin-left: 18px;" class=" rounded" alt="Profile Image of Cast member">
    <div class="font-weight-normal mt-2" style="line-height: 5px; overflow-y: hidden;">
    <p><b>Popularity</b></p><p>${cast[i].popularity}<p>
    <p class="mx-2">Original Name</p><p>${cast[i].original_name}</p>
    <p class="">Character </p><p>${cast[i].character}</p>
</div>
</span></li>
                    `;
                }
                $("#cast_div").html(html);
            }
        });

    });
</script>

</body>
</html>