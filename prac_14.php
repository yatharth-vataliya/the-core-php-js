<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Prac 14 movie db api</title>
</head>
<body>

<div class="container-fluid">
    <div id="add_movie" class="row">
        <!-- <div class="p-2 shadow rounded float-left" style="width: 18em;">
          <img src="https://image.tmdb.org/t/p/original/kiX7UYfOpYrMFSAGbI6j1pFkLzQ.jpg" class="rounded float-left" style="width: 5em; height:5em;" alt="">
        </div> -->
    </div>
</div>
<div class="container-fluid">
    <div class="row m-2 p-2">
        <div class="col-md">
            <button type="button" onclick="getMovies();" class="btn btn-outline-primary btn-block">Load More</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>

<script>
    var page = 0;

    /*function getMovies(){
      var http = new XMLHttpRequest();
      http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          response = JSON.parse(this.response);
          movies = response.results;
          var mv ='';
          for(i = 0; i < movies.length; i++){
            mv += `<div class="rounded shadow text-break col-md-3 m-5" style="text-overflow: ellipsis; overflow: hidden; width: 200px; height: 250px;">
        <div class="row">
          <div class="col-md">
            <a href="https://www.themoviedb.org/movie/${movies[i].id}">
              <img src="https://image.tmdb.org/t/p/original/${movies[i].poster_path}" style="width: 100px; height: 250px;" class="rounded" alt="${movies[i].original_title}">
            </a>
          </div>
          <div class="col-md">
            <strong>Title</strong>
            <p><a href="https://www.themoviedb.org/movie/${movies[i].id}">${movies[i].original_title}</a></p>
            <strong>Overview</strong>
            <p style="width: 20px; height: 20px;text-overflow: ellipsis;white-space: nowrap;
overflow: hidden;">${movies[i].overview}</p>
            <strong>Popularity</strong>
            <p>${movies[i].popularity}</p>
            <strong>Release Date</strong>
            <p>${movies[i].release_date}</p>
            <strong>Average Vote</strong>
            <p>${movies[i].vote_average}</p>
            <strong>Total Vote</strong>
            <p>${movies[i].vote_count}</p>
          </div>  
        </div>
      </div>`;
          }
          document.getElementById('add_movie').innerHTML += mv;
          page = response.page;
        }
      }
      http.open("POST",`movie_api.php?page=${++page}`);
      http.send();
    }*/
    function getMovies() {
        var http = new XMLHttpRequest();
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                response = JSON.parse(this.response);
                movies = response.results;
                var mv = '';
                for (i = 0; i < movies.length; i++) {
                    mv += `<div class="rounded shadow text-break col-md-3 m-5" style="text-overflow: ellipsis; overflow: hidden; width: 200px; height: 250px;">
        <div class="row">
          <div class="col-md">
            <a href="movie_page.php?movie_id=${movies[i].id}" target="_blank">
              <img src="https://image.tmdb.org/t/p/original/${movies[i].poster_path}" style="width: 100px; height: 250px;" class="rounded" alt="${movies[i].original_title}">
            </a>
          </div>
          <div class="col-md">
            <strong>Title</strong>
            <p><a href="movie_page.php?movie_id=${movies[i].id}" target="_blank">${movies[i].original_title}</a></p>
            <strong>Overview</strong>
            <p style="width: 20px; height: 20px;text-overflow: ellipsis;white-space: nowrap;
overflow: hidden;">${movies[i].overview}</p>
            <strong>Popularity</strong>
            <p>${movies[i].popularity}</p>
            <strong>Release Date</strong>
            <p>${movies[i].release_date}</p>
            <strong>Average Vote</strong>
            <p>${movies[i].vote_average}</p>
            <strong>Total Vote</strong>
            <p>${movies[i].vote_count}</p>
          </div>
        </div>
      </div>`;
                }
                document.getElementById('add_movie').innerHTML += mv;
                page = response.page;
            }
        }
        http.open("GET", `https://api.themoviedb.org/3/discover/movie?api_key=a0acb84bc12a6a187fbf5cf4431ea867&page=${++page}`);
        http.send();
    }

    getMovies();
</script>

</body>
</html>