<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Satuan Unit Militer</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <nav>
        <h1>Manajemen Unit militer</h1>
        <a id="logout" class="delete" href="/logout">Logout</a>
        <br>
        <br>
    </nav>
    @if(session('error'))
        <div style="color:red">
            {{ session('error') }}
        </div>
    @endif
    <div class="units-container">
        <div class="tree-actions">
            <button id="expandAll" class="expand">Expand All</button>
            <button id="collapseAll" class="collapse">Collapse All</button>
        </div>
        <ul>
            @foreach ($units as $unit)
                @include('units.list', ['unit' => $unit])
            @endforeach
        </ul>
    </div>

    <div id="createUnitModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Unit Baru</h3>
            Buat unit baru di bawah <b id="namaUnit"></b>
            <form id="createUnitForm" action='' method="post">
            @csrf
            <label>Nama Unit</label>
            <input type="text" id="unitName" name="name" required>

            <label>URL foto</label>
            <input type="text" id="unitImage" name="image_url">

            <label>Pemimpin</label>
            <input type="text" id="unitLeader" name="leader">

            <label>Deskripsi</label>
            <input type="text" id="unitDescription" name="description">

            <label>Lokasi</label>
            <input type="text" id="unitLocation" name="location">

            <input type="hidden" id="parentId" name="parent_id">

            <div class="modal-actions">
                <button type="submit">Simpan</button>
                <button type="button" class="close">Batal</button>
            </div>
            </form>
        </div>
    </div>
    
    <div id="editUnitModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Edit Unit</h3>
            <form id="createUnitForm" action='/edit' method="post">

            @csrf
            <label>Nama Unit</label>
            <input type="text" id="unitNameEdit" name="name" required>

            <label>URL foto</label>
            <input type="text" id="unitImageEdit" name="image_url">

            <label>Pemimpin</label>
            <input type="text" id="unitLeaderEdit" name="leader">

            <label>Deskripsi</label>
            <input type="text" id="unitDescriptionEdit" name="description">

            <label>Lokasi</label>
            <input type="text" id="unitLocationEdit" name="location">

            <input type="hidden" name="id" id="unitIdEdit">

            <p>Untuk memindahkan unit ke pimpinan lain, hapus unit terlebih dahulu kemudian ditambahkan sebagai unit baru</p>

            <div class="modal-actions">
                <button type="submit">Simpan</button>
                <button type="button" class="close">Batal</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('expandAll').addEventListener('click', () => {
            document.querySelectorAll('.toggle:not(:disabled)').forEach(cb => cb.checked = true);
        });

        document.getElementById('collapseAll').addEventListener('click', () => {
            document.querySelectorAll('.toggle:not(:disabled)').forEach(cb => cb.checked = false);
        });

        const createUnitModal = document.getElementById('createUnitModal');
        const editUnitModal = document.getElementById('editUnitModal');
        document.querySelectorAll('.close').forEach(btn => btn.addEventListener('click', () =>{
            createUnitModal.style.display = 'none';
            editUnitModal.style.display = 'none';
        }));
        document.querySelectorAll('.add').forEach(btn => btn.addEventListener('click', (el) => {
            const data=el.srcElement.closest(".actions").dataset;
            console.log(data);
            document.getElementById("namaUnit").innerText=data.name;
            document.getElementById("parentId").value=data.id;
            createUnitModal.style.display = 'flex'
        }));

        document.querySelectorAll('.edit').forEach(btn => btn.addEventListener('click', (el) => {
            const data=el.srcElement.closest(".actions").dataset;
            console.log(data);
            document.getElementById("unitNameEdit").value=data.name;
            document.getElementById("unitImageEdit").value=data.image;
            document.getElementById("unitLeaderEdit").value=data.leader;
            document.getElementById("unitDescriptionEdit").value=data.description;
            document.getElementById("unitLocationEdit").value=data.location;
            document.getElementById("unitIdEdit").value=data.id;
            editUnitModal.style.display = 'flex';
        }));

    </script>
</body>
</html>