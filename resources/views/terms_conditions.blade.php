<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cho's Studio</title>
  <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* Scrollbar styling */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background-color: rgba(120, 120, 120, 0.6);
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background-color: rgba(120, 120, 120, 0.8);
    }
    ::-webkit-scrollbar-button {
      display: none;
    }
  </style>
</head>

<body class="bg-[#f8f4ef]">

  <div class="flex justify-center items-center h-[100vh]  font-[HammersmithOne-Regular]">
    <div class="bg-[#f0ebe3] w-[75%] h-[80%] outline-4 rounded-2xl p-8 overflow-y-auto shadow-md">
      <!-- Header -->
      <h1 class="text-4xl sm:text-5xl mb-4 text-center text-[#2c2c2c]">Terms and Conditions</h1>
      <hr class="border-t-2 border-[#2c2c2c] opacity-20 mb-4 w-[80%] mx-auto">

      <!-- Content -->
        <div class="text-[#2c2c2c] text-justify leading-relaxed space-y-4 pr-2">
            <p>
                <b>Ketentuan Umum</b><br />
                Dengan mengakses dan menggunakan layanan Cho’s Studio, pengguna dianggap telah membaca,
                memahami, dan menyetujui seluruh ketentuan yang berlaku. Semua aset visual, ilustrasi, dan
                karya seni yang ditampilkan merupakan hak cipta dari seniman terkait.
            </p>

            <p>
                <b>Hak Cipta dan Larangan Penggunaan</b><br />
                Pengguna dilarang untuk menyebarluaskan, menyalin, atau menggunakan ulang aset yang tersedia
                tanpa izin tertulis. Sistem ini memiliki perlindungan tambahan untuk mencegah tindakan seperti
                pengambilan gambar (screenshot) dan penyimpanan langsung terhadap aset.
            </p>

            <p>
                <b>Data dan Privasi</b><br />
                Seluruh data pengguna yang disimpan melalui proses registrasi akan masuk ke dalam basis data
                (database) resmi Cho’s Studio. Data tersebut digunakan untuk kepentingan pengelolaan akun,
                peningkatan layanan, serta keamanan sistem. Dengan melakukan registrasi akun, pengguna
                menyetujui pengumpulan dan penyimpanan data seperti nama, alamat email, serta aktivitas dalam platform.
            </p>

            <p>
                <b>Akun dan Keamanan</b><br />
                Pengguna diharapkan menggunakan akun secara benar dan bertanggung jawab. Menjaga kerahasiaan
                kata sandi merupakan tanggung jawab pribadi pengguna. Apabila pengguna lupa atau kehilangan
                akses terhadap kata sandinya, maka terdapat kemungkinan sebagian atau seluruh data yang tersimpan
                tidak dapat dipulihkan.
            </p>

            <p>
                <b>Ketentuan Penggunaan</b><br />
                Dengan menerima ketentuan ini, pengguna menyetujui untuk menggunakan layanan secara etis
                dan sesuai kebijakan platform. Pelanggaran terhadap ketentuan ini dapat mengakibatkan pembatasan,
                penangguhan, atau penghapusan akun.
            </p>

            <p>
                Jika pengguna tidak menyetujui salah satu dari ketentuan di atas, proses pendaftaran atau penggunaan
                layanan tidak dapat dilanjutkan.
            </p>
        </div>


      <!-- Buttons -->
      <div class="flex justify-end gap-3 mt-6">
        <button
          id="declineBtn"
          class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-all duration-200">
          Decline
        </button>

        <button
          id="acceptBtn"
          class="bg-[#ffac81] hover:bg-[#ff9961] text-[#2c2c2c] px-6 py-2 rounded-lg transition-all duration-200">
          Accept
        </button>
      </div>
    </div>
  </div>

  <!-- Script fungsi tombol -->
  <script>
    document.getElementById('declineBtn').addEventListener('click', () => {
      alert('Register cannot be proceed.');
    });

    document.getElementById('acceptBtn').addEventListener('click', () => {
        window.location.href = "{{ route('register') }}?accepted=1";
    });
  </script>

</body>
</html>
