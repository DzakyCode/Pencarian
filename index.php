<?php
include 'config.php';
session_start();

// ambil semua data untuk inisialisasi JS
$negara_q = mysqli_query($conn, "SELECT id_negara, nama_negara FROM negara WHERE deleted_at IS NULL ORDER BY nama_negara");
$provinsi_q = mysqli_query($conn, "SELECT id_provinsi, id_negara, nama_provinsi FROM provinsi WHERE deleted_at IS NULL ORDER BY nama_provinsi");
$kota_q = mysqli_query($conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota WHERE deleted_at IS NULL ORDER BY nama_kota");

// juga siapkan query utama (gabung jenis pemerintahan - ambil first sistem untuk negara jika ada banyak)
$query = "
    SELECT n.id_negara, n.nama_negara, j.sistem_pemerintahan, p.id_provinsi, p.nama_provinsi, k.id_kota, k.nama_kota
    FROM negara n
    LEFT JOIN jenis_pemerintahan j ON n.id_negara = j.id_negara AND j.deleted_at IS NULL
    LEFT JOIN provinsi p ON n.id_negara = p.id_negara AND p.deleted_at IS NULL
    LEFT JOIN kota k ON p.id_provinsi = k.id_provinsi AND k.deleted_at IS NULL
    WHERE n.deleted_at IS NULL
    ORDER BY n.nama_negara, p.nama_provinsi, k.nama_kota
";
$result = mysqli_query($conn, $query);
$rows = [];
while($r = mysqli_fetch_assoc($result)) $rows[] = $r;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mesin Pencarian Wilayah</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>

<header>
    <h1>Mesin Pencarian Wilayah</h1>
    <div class="header-right">
        <?php if(isset($_SESSION['admin'])): ?>
            <a href="admin.php" class="btn-admin">Dashboard</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login Admin</a>
        <?php endif; ?>
        <button id="themeToggle" class="btn-add" style="margin-left:8px;">Toggle Theme</button>
    </div>
</header>

<main>
    <div style="display:flex;gap:10px;align-items:center;margin-bottom:12px;">
      <select id="filterNegara">
        <option value="">Semua Negara</option>
        <?php while($n = mysqli_fetch_assoc($negara_q)): ?>
          <option value="<?= $n['id_negara'] ?>"><?= htmlspecialchars($n['nama_negara']) ?></option>
        <?php endwhile; ?>
      </select>

      <select id="filterProvinsi">
        <option value="">Semua Provinsi</option>
        <?php while($p = mysqli_fetch_assoc($provinsi_q)): ?>
          <option data-negara="<?= $p['id_negara'] ?>" value="<?= $p['id_provinsi'] ?>"><?= htmlspecialchars($p['nama_provinsi']) ?></option>
        <?php endwhile; ?>
      </select>

      <select id="filterKota">
        <option value="">Semua Kota</option>
        <?php while($k = mysqli_fetch_assoc($kota_q)): ?>
          <option data-provinsi="<?= $k['id_provinsi'] ?>" value="<?= $k['id_kota'] ?>"><?= htmlspecialchars($k['nama_kota']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <table id="wilayahTable" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>Negara</th>
                <th>Jenis Pemerintahan</th>
                <th>Provinsi</th>
                <th>Kota</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach($rows as $row){
                echo "<tr>
                        <td>{$no}</td>
                        <td>".htmlspecialchars($row['nama_negara'])."</td>
                        <td>".htmlspecialchars($row['sistem_pemerintahan'])."</td>
                        <td>".htmlspecialchars($row['nama_provinsi'])."</td>
                        <td>".htmlspecialchars($row['nama_kota'])."</td>
                      </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</main>

<script>
$(document).ready(function(){
    var table = $('#wilayahTable').DataTable({
        pageLength: 10,
        order: []
    });

    function applyFilters(){
        var negara = $('#filterNegara').val();
        var provinsi = $('#filterProvinsi').val();
        var kota = $('#filterKota').val();

        table.rows().every(function(){
            var data = this.data();
            var show = true;

            // data: [No, Negara, Jenis, Provinsi, Kota]
            if(negara){
                // compare negara by matching the cell text to selected option's text
                var foundNegaraText = $("#filterNegara option:selected").text().toLowerCase();
                if( (data[1]||'').toLowerCase() !== foundNegaraText.toLowerCase() ) show = false;
            }
            if(provinsi && show){
                var provText = $("#filterProvinsi option:selected").text().toLowerCase();
                if( (data[3]||'').toLowerCase() !== provText.toLowerCase() ) show = false;
            }
            if(kota && show){
                var kotaText = $("#filterKota option:selected").text().toLowerCase();
                if( (data[4]||'').toLowerCase() !== kotaText.toLowerCase() ) show = false;
            }

            if(show) $(this.node()).show(); else $(this.node()).hide();
        });
    }

    $('#filterNegara').on('change', function(){
        var id = $(this).val();
        // show/hide provinsi options based on data-negara attr
        $('#filterProvinsi option').each(function(){
            var $opt = $(this);
            var negaraId = $opt.data('negara');
            if(!id){
                $opt.show();
            } else {
                if(negaraId == id) $opt.show(); else $opt.hide();
            }
        });

        // reset provinsi and kota selection if needed
        $('#filterProvinsi').val('');
        $('#filterKota').val('');
        applyFilters();
    });

    $('#filterProvinsi').on('change', function(){
        var id = $(this).val();
        // show/hide kota options based on data-provinsi attr
        $('#filterKota option').each(function(){
            var $opt = $(this);
            var provId = $opt.data('provinsi');
            if(!id){
                $opt.show();
            } else {
                if(provId == id) $opt.show(); else $opt.hide();
            }
        });

        $('#filterKota').val('');
        applyFilters();
    });

    $('#filterKota').on('change', applyFilters);

    // Theme toggle (store in localStorage)
    function applyTheme(){
        var theme = localStorage.getItem('theme') || 'light';
        if(theme === 'dark') document.body.classList.add('dark-mode'); else document.body.classList.remove('dark-mode');
    }
    $('#themeToggle').on('click', function(){
        var t = localStorage.getItem('theme') === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', t);
        applyTheme();
    });
    applyTheme();
});
</script>

</body>
</html>
