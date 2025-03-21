<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-[#F6F6F6]">

<div class="relative z-10 flex flex-col md:flex-row items-top justify-between w-[90%] lg:w-[90%]
 min-h-[90vh] bg-opacity-0  p-8 rounded-[50px]  "> <!--backdrop-blur-lg -->

        <!-- Left Card: College Name -->
        <div class="w-full md:w-1/2 p-10 text-[#001840] font-bold bg-opacity-0">
    <h1 class="text-7xl ml-24 mt-12 leading-tight mb-12">Get Started:<br>Register Now<br>and Make Your<br>Opinion Count</h1>
</div>

        <!-- Right Card: Login Form -->
        <div class="w-full max-w-2xl bg-[#D9D9D9] bg-opacity-90 backdrop-blur-md p-8 rounded-xl shadow-md border border-gray-300 m-10 min-h-[400px] flex flex-col">

    <!-- Heading at the top -->
    <h2 class="text-3xl font-bold text-center text-[#001840] mt-12">To Create an Account:</h2>

    <!-- Error Message -->
    @if ($errors->any())
        <div class="p-3 my-2 text-sm text-red-600 bg-red-100 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Centered Form -->
    <div class="flex flex-grow items-center justify-center">
        <form action="{{ route(name: 'verification') }}" method="POST" class="w-full flex flex-col items-center">
            @csrf

            <div class="mb-12">
                <input type="text" name="student_number" placeholder="Student Number"
                    class="w-[500px] px-4 min-h-[90px] border rounded-lg focus:ring focus:ring-blue-300 text-gray-700 placeholder-gray-400 placeholder:text-3xl" required>
            </div>

            <!-- Register Button -->
            <div class="mt-4">
                <button type="submit" class="w-[450px] px-4 py-4 bg-[#143B8E] text-white rounded-lg hover:bg-gray-400 font-semibold text-center block text-[30px] ">Verify</button>
            </div>


        </div>
    </div>

</body>
</html>
