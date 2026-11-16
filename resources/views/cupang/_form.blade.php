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
