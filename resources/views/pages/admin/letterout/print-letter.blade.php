<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Surat Keluar</title>
</head>

<body>

    <section id="main">
        <div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <table border="1" width="100%">
                            <tbody>
                                <tr>
                                    <td valign="top">
                                        <div align="center">
                                            <span style="font-size: x-small;">&emsp;&emsp;&emsp;&emsp;<img src="/admin/assets/img/logo.png" style="max-width: 7rem;" alt="Gambar iahn"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <table border="0" cellpadding="1" style="width: 500px;text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%"><span style="font-size: x-small;">
                                                            <h6>UNIVERSITAS PALANGKA RAYA</h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100%"><span style="font-size: x-small;">
                                                            <center>
                                                                <pre>Jln. Yos Sudarso Palangka Raya Kalimantan Tengah, 73111 <br> www.upr.ac.id</pre>
                                                            </center>
                                                        </span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        @php
                        $attach = 1;
                        @endphp
                        <table class="table table-sm table-bordered" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 20%; text-align: left; font-size: small;">No</td>
                                    <td style="text-align: left; font-size: small;">: {{ $item->letter_no; }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-size: small;">Lampiran</td>
                                    <td style="text-align: left; font-size: small;">: {{ $attach; }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-size: small;">Hal</td>
                                    <td style="text-align: left; font-size: small;">: {{ $item->regarding; }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="margin-top: 80px;">
                            {{ $item->content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        window.print();
        window.onafterprint = window.close;
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>