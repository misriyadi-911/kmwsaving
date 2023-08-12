<div class="d-flex">
  <div class="dropdown d-inline-block">
    <span class="d-none d-xl-inline-block ms-1 text-white" key="t-henry"><?= $getResource['nama'] ?></span>
    <button type="button" class="btn header-item waves-effect">
      <?php if ($getResource['type'] == 'guru') : ?>
        <img class="rounded-circle header-profile-user" src="./upload/guru/<?= $getResource['thumbnail'] ?>" alt="Header Avatar">
      <?php elseif ($getResource['type'] == 'siswa') : ?>
        <img class="rounded-circle header-profile-user" src="./upload/siswa/<?= $getResource['thumbnail'] ?>" alt="Header Avatar">
      <?php else : ?>
        <img class="rounded-circle header-profile-user" src="./upload/iStock-476085198.jpg" alt="Header Avatar">
      <?php endif ?>
    </button>
  </div>
  <?php if ($getResource['type'] !== 'admin') : ?>
    <div class="dropdown d-inline-block">
      <a class="btn header-item waves-effect text-white py-4" href="?page=dashboard&bagian=forgot&id=<?= $_SESSION['id_pengguna'] ?>">
        <i class="bx bx-cog font-size-20"></i></a>
    </div>
  <?php endif ?>
  <div class="dropdown d-inline-block">
    <a class="btn py-4 header-item waves-effect" href="./logout.php">
      <i class="bx bx-power-off font-size-20 text-white"></i>
    </a>
  </div>
</div>