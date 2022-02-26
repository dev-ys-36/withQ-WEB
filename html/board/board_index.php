<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>withQ network</title>
        <!-- Favicon
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />-->
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

        <script>
        jQuery(document).ready(function ($) {
            $('[data-href]').click(function () {
                window.location = $(this).data("href");
            });
        });
        </script>

        <style>
        table th, td {
            text-align: center;
        }
        .center {
            text-align: center;
        }
        </style>
	</head>
   <body>
        <!-- Responsive navbar -->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="/">withQ network</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
			    <div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php
                        if (isset($argv[1]) and isset($argv[2])){
                            echo '<li class="nav-item"><a class="nav-link active" href="">게시판</a></li>';
                            echo '<li class="nav-item"><a class="nav-link active" href="profile">내정보</a></li>';
                            echo '<li class="nav-item"><a class="nav-link active" href="logout">로그아웃</a></li>';
                        }else{
                            echo '<li class="nav-item"><a class="nav-link active" href="">게시판</a></li>';
                            echo '<li class="nav-item"><a class="nav-link active" href="login">로그인</a></li>';
                        }
                        ?>
					</ul>
				</div>
			</div>
        </nav>
        <!-- Features section-->
        <section class="py-5 border-bottom" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                <a class="btn btn-dark" href="board/write" role="button">글쓰기</a>
                <table id="offline_table" class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width:3em"><div class='center'>번호</div></th>
                        <th scope="col"><div class='center'>게시판</div></th>
                        <th scope="col" class="text-left" style="width:8em"><div class='center'>작성자</div></th>
                        <th scope="col" class="text-left" style="width:4em"><div class='center'>조회수</div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                    include './utils/DataManager.php';

                    $board_data = new utils\DataManager('/root/web/datas/board_data.json', utils\DataManager::JSON);
	                $db['board_data'] = $board_data->getAll();

                    arsort($db['board_data']['board-data']);

                    foreach($db['board_data']['board-data'] as $datas){

                        echo '<tr data-href=/board/' . $datas['num'] . '>';
                        echo '<td>' . $datas['num'] . '</td>';
                        echo '<td>' . $datas['title'] . '</td>';
                        echo '<td>' . $datas['writer'] . '</td>';
                        echo '<td>' . $datas['view'] . '</td>';
                        echo '</tr>';

                    }

                    ?>
                </tbody>
                </table>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-5">
			<p class="m-0 text-center text-white">Copyright &copy; <b>withQ network</b> 2021. All rights reserved.
			<a href="http://validator.kldp.org/check?uri=referer" onclick="this.href=this.href.replace(/referer$/,encodeURIComponent(document.URL))"><img src="//validator.kldp.org/w3cimgs/validate/html5-blue.png" alt="Valid HTML 5" height="15" width="80"></a>
			</p>
			</div>
        </footer>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>