<?php include("path.php");
include "app/controllers/topics.php";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 3;
$offset = $limit * ($page - 1);
$total_pages = round(countRow('posts') / $limit, 0);

$posts = selectAllFromPostsWithUsersOnIndex('posts', 'users', $limit, $offset);
$topTopic = selectTopTopicFromPostsOnIndex('posts');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Shantell+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />
</head>

<body>
  <?php include("app/include/header.php"); ?>
  <div class="container">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php foreach ($topTopic as $key => $post) : ?>
          <?php if ($key == 0) : ?>
            <div class="carousel-item active">
            <?php else : ?>
              <div class="carousel-item">
              <?php endif; ?>
              <a href="<?= BASE_URL . 'single.php?post=' . $post['id']; ?>"><?= substr($post['title'], 0, 120) . '...'  ?>
                <img src="<?= BASE_URL . 'images/posts/' . $post['image'] ?>" alt="<?= $post['title'] ?>" class="d-block w-100">
              </a>
              <div class="carousel-caption d-none d-md-block">
              </div>
              </div>
            <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
      </div>
    </div>
    <div class="container">
      <div class="content row">
        <!-- Main Content -->
        <div class="main-content col-md-9 col-12 mt-5">
          <h2>Последние публикации</h2>
          <?php foreach ($posts as $post) : ?>
            <div class="post row">
              <div class="img col-12 col-md-4">
                <img src="<?= BASE_URL . 'images/posts/' . $post['image'] ?>" alt="<?= $post['title'] ?>" class="img-thumbnail">
              </div>
              <div class="post_text col-12 col-md-8">
                <h3>
                  <a href="<?= BASE_URL . 'single.php?post=' . $post['id']; ?>"><?= substr($post['title'], 0, 80) . '...'  ?></a>
                </h3>
                <i class="far fa-user"> <?= $post['username']; ?></i>
                <i class="far fa-calendar"> <?= $post['created_date']; ?></i>
                <p class="preview-text">

                  <?= mb_substr($post['content'], 0, 55, 'UTF-8') . '...'  ?>
                </p>
              </div>
            </div>
          <?php endforeach; ?>
          <?php include("app/include/pagination.php"); ?>
        </div>
        <!-- sidebar Content -->
        <div class="sidebar col-md-3 col-12">

          <div class="section search">
            <h3>Поиск</h3>
            <form action="search.php" method="post">
              <input type="text" name="search-term" class="text-input" placeholder="Введите искомое слово...">
            </form>
          </div>


          <div class="section topics">
            <h3>Категории</h3>
            <ul>
              <?php foreach ($topics as $key => $topic) : ?>
                <li>
                  <a href="<?= BASE_URL . 'category.php?id=' . $topic['id']; ?>"><?= $topic['name']; ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

        </div>

      </div>

    </div>

    <!-- footer -->
    <?php include("app/include/footer.php"); ?>
    <!-- // footer -->


    <script src="https://kit.fontawesome.com/a4819e9e93.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>