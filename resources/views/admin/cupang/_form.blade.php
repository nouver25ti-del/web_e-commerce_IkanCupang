@csrf
<label for="kode">Kode</label>
<input id="kode" name="kode" value="{{ old('kode', $cupang->kode) }}" placeholder="CP-007" required>
@error('kode')<p class="err">{{ $message }}</p>@enderror

<label for="nama">Nama cupang</label>
<input id="nama" name="nama" value="{{ old('nama', $cupang->nama) }}" placeholder="Plakat Galaxy" required>
@error('nama')<p class="err">{{ $message }}</p>@enderror

<div class="two">
  <div>
    <label for="jenis">Jenis</label>
    <select id="jenis" name="jenis">
      @foreach (\App\Models\Cupang::JENIS as $j)
        <option @selected(old('jenis', $cupang->jenis) === $j)>{{ $j }}</option>
      @endforeach
    </select>
    @error('jenis')<p class="err">{{ $message }}</p>@enderror
  </div>
  <div>
    <label for="warna">Warna</label>
    <select id="warna" name="warna">
      @foreach (array_keys(\App\Models\Cupang::WARNA) as $w)
        <option @selected(old('warna', $cupang->warna) === $w)>{{ $w }}</option>
      @endforeach
    </select>
    @error('warna')<p class="err">{{ $message }}</p>@enderror
  </div>
  <div>
    <label for="harga">Harga (Rp)</label>
    <input id="harga" name="harga" type="number" min="0" value="{{ old('harga', $cupang->harga) }}" required>
    @error('harga')<p class="err">{{ $message }}</p>@enderror
  </div>
  <div>
    <label for="stok">Stok</label>
    <input id="stok" name="stok" type="number" min="0" value="{{ old('stok', $cupang->stok) }}" required>
    @error('stok')<p class="err">{{ $message }}</p>@enderror
  </div>
</div>

<label for="gambar">Foto cupang</label>
<img class="preview" id="preview" alt="Pratinjau foto" @if ($cupang->gambar) src="{{ asset('uploads/cupang/'.$cupang->gambar) }}" @else hidden @endif>
<input id="gambar" name="gambar" type="file" accept="image/png,image/jpeg,image/webp">
<p class="hint">JPG, PNG, atau WebP, maksimal 2 MB. Kosongkan untuk memakai gambar bawaan.</p>
@error('gambar')<p class="err">{{ $message }}</p>@enderror
@if ($cupang->gambar)
  <label class="cek"><input type="checkbox" name="hapus_gambar" value="1"> Hapus foto ini</label>
@endif
<script>
document.getElementById('gambar').addEventListener('change', function () {
  var img = document.getElementById('preview'), f = this.files[0];
  if (!f) return;
  img.src = URL.createObjectURL(f); img.hidden = false;
});
</script>
