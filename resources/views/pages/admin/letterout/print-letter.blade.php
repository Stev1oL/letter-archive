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

    <section id="main" style="margin: 0;">
        <div class="container" style="margin: 0 auto; max-width: 210mm; text-align: center;">
            <img src="/admin/assets/img/word-header.jpg" style="margin: 0; width: 100%; max-width: 100%; height: auto;" alt="header">
        </div>
        <br>
        <table class="table table-sm" style="width: 100%; border: none;">
            <tbody>
                <tr style="border: none;">
                    <td style="width: 20%; text-align: left; font-size: small; border: none;">No</td>
                    <td style="text-align: left; font-size: small; border: none;">: {{ $item->letter_no }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="text-align: left; font-size: small; border: none;">Lampiran</td>
                    <td style="text-align: left; font-size: small; border: none;">: {{ $item->copy }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="text-align: left; font-size: small; border: none;">Hal</td>
                    <td style="text-align: left; font-size: small; border: none;">: {{ $item->regarding }}</td>
                </tr>
            </tbody>
        </table>
        <div style="margin-top: 30px; text-align: justify;">
            {!! $item->content !!}
        </div>
        <br>
        <div class="footer" style="position: fixed; bottom: 0; left: 0; width: 100%;">
            <img src="/admin/assets/img/word-footer.jpg" style="margin: 0; width: 100%; max-width: 100%;" alt="footer">
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