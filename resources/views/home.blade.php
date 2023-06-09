<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CSV Uploader</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite('resources/css/app.css')
    </head>
    <body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
  <img class="mx-auto h-10 w-auto" src="https://uploads-ssl.webflow.com/5e38423084bb96caf84a40ce/5e68def37c7882fc13150c59_Group%20Logo%20-%20Black-p-500.png" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">CSV Uploader</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="" method="POST" enctype="multipart/form-data">
      @csrf <!-- {{ csrf_field() }} -->
      <div>
        <label for="file" class="block text-sm font-medium leading-6 text-gray-900">File</label>
        <div class="mt-2">
          <input id="file" name="attachment" type="file" required class="block w-full rounded-md border-0 px-1.5 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
      </div>
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      @if (isset($people))
        <div class="alert alert-danger">
          Results:
            <table class="table-auto w-full">
              <thead>
                <th>Title</th>
                <th>Initial</th>
                <th>Firstname</th>
                <th>Lastname</th>
              </thead>
              <tbody>
                @foreach ($people as $person)
                  <tr>
                    <td>{{$person['title']}}</td>
                    <td>{{$person['initial']}}</td>
                    <td>{{$person['firstname']}}</td>
                    <td>{{$person['surname']}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      @endif
    </form>
  </div>
</div>
    </body>
</html>
