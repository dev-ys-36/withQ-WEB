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

        <style>
        table th, td {
            text-align: center;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
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
                        if (isset($argv[2]) and isset($argv[3])){
                            echo '<li class="nav-item"><a class="nav-link active" href="/board">?????????</a></li>';
                            echo '<li class="nav-item"><a class="nav-link active" href="/profile">?????????</a></li>';
                            echo '<li class="nav-item"><a class="nav-link active" href="/logout">????????????</a></li>';
                        }else{
                            echo '<li class="nav-item"><a class="nav-link active" href="/board">?????????</a></li>';
                            echo '<li class="nav-item"><a class="nav-link active" href="/login">?????????</a></li>';
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
                    <div class="col d-flex justify-content-center">
						<div class="card border-primary mb-3" style="width: 40rem;">
							<div class="card-body text-primary">
								<div class="card-text">
                                    <?php
                                    
                                    include './utils/DataManager.php';
                            
                                    $board_data = new utils\DataManager('/root/web/datas/board_data.json', utils\DataManager::JSON);
                                    $db['board_data'] = $board_data->getAll();
                
                                    foreach($db['board_data']['board-data'] as $datas){
                
                                        if ($datas['num'] == $argv[1]){
                
                                            //echo '<div class="card-header">?????????: ' . $datas['view'] . '</div>';
                                            echo '<div class="card-body">';
                                            echo '<h3 class="display-5 fw-bolder text-black mb-2">' . $datas['title'] . '</h3>';
                                            echo '<br>';
                                            echo '<p class="card-text">' . nl2br($datas['content']) . '</p>';
                                            echo '<br>';
                                            echo '<p class="card-text"><small class="text-muted">?????????: ' . $datas['view'] . '</small></p>';
                                            echo '</div>';
                
                                            break;
                                        
                                        }
                                
                                    }
                                    ?>
								</div>
							</div>
						</div>
                    </div>
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