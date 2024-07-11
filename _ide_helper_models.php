<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Alquran
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Alquran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alquran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alquran query()
 */
	class Alquran extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Distribusi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Distribusi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Distribusi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Distribusi query()
 */
	class Distribusi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Handphone
 *
 * @property int $id
 * @property string $merk
 * @property string $tipe
 * @property string $warna
 * @property string $imei1
 * @property string $imei2
 * @property string $serial_number
 * @property string|null $kode_inventaris
 * @property string|null $no_hp
 * @property int|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone query()
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereImei1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereImei2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereKodeInventaris($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handphone whereWarna($value)
 */
	class Handphone extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IT
 *
 * @method static \Illuminate\Database\Eloquent\Builder|IT newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IT newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IT query()
 */
	class IT extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Inventaris
 *
 * @property int $id
 * @property string $nama
 * @property string $no_hp
 * @property string $jabatan
 * @property string $area
 * @property string $warna
 * @property string $imei
 * @property string $serial_number
 * @property string $kd_inventaris
 * @property string $wilayah
 * @property string|null $imei_baru
 * @property string|null $tgl_maintenance
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris query()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereImei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereImeiBaru($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereKdInventaris($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereTglMaintenance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereWarna($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventaris whereWilayah($value)
 */
	class Inventaris extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Keuangan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Keuangan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keuangan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keuangan query()
 */
	class Keuangan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Maintenance
 *
 * @property int $id
 * @property int $id_pegawai
 * @property int $id_handphone
 * @property string|null $keterangan
 * @property string|null $id_pegawai_sebelumnya
 * @property string|null $tgl_maintenance
 * @property string|null $fisik
 * @property string|null $fungsi
 * @property string|null $m_imei
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Handphone|null $handphone
 * @property-read \App\Models\Pegawai|null $pegawai
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereFisik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereFungsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereIdHandphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereIdPegawai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereIdPegawaiSebelumnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereMImei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereTglMaintenance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Maintenance whereUpdatedAt($value)
 */
	class Maintenance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Officeboy
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Officeboy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Officeboy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Officeboy query()
 */
	class Officeboy extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pegawai
 *
 * @property int $id
 * @property string $nama
 * @property string $jabatan
 * @property string $wilayah
 * @property string $area
 * @property int|null $status
 * @property int|null $status2
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai whereStatus2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pegawai whereWilayah($value)
 */
	class Pegawai extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pemasaran
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pemasaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pemasaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pemasaran query()
 */
	class Pemasaran extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pengadaan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pengadaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengadaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengadaan query()
 */
	class Pengadaan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pengembanganperusahaan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pengembanganperusahaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengembanganperusahaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengembanganperusahaan query()
 */
	class Pengembanganperusahaan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pengendalian
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pengendalian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengendalian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengendalian query()
 */
	class Pengendalian extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Perencanaan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Perencanaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perencanaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perencanaan query()
 */
	class Perencanaan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Produksi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Produksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Produksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Produksi query()
 */
	class Produksi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Satpam
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Satpam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Satpam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Satpam query()
 */
	class Satpam extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sdm
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Sdm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sdm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sdm query()
 */
	class Sdm extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sekper
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Sekper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sekper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sekper query()
 */
	class Sekper extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Spi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Spi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spi query()
 */
	class Spi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $role
 * @property string|null $jabatan
 * @property string|null $divisi
 * @property string|null $agama
 * @property string|null $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

