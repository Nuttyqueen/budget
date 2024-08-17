<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>แก้ไขข้อมูลสมาชิก</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="prefix">คำนำหน้าชื่อ</label>
                <select name="prefix" id="prefix" class="form-control">
                    <option value="นาย" {{ $member->prefix == 'นาย' ? 'selected' : '' }}>นาย</option>
                    <option value="นาง" {{ $member->prefix == 'นาง' ? 'selected' : '' }}>นาง</option>
                    <option value="นางสาว" {{ $member->prefix == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                </select>
            </div>

            <div class="form-group">
                <label for="first_name">ชื่อ</label>
                <input type="text" name="first_name" id="first_name" class="form-control"
                    value="{{ old('first_name', $member->first_name) }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">นามสกุล</label>
                <input type="text" name="last_name" id="last_name" class="form-control"
                    value="{{ old('last_name', $member->last_name) }}" required>
            </div>

            <div class="form-group">
                <label for="birthdate">วันเดือนปีเกิด</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control"
                    value="{{ old('birthdate', $member->birthdate) }}" required>
            </div>

            <div class="form-group">
                <label for="profile_image">รูปภาพโปรไฟล์</label>
                <input type="file" name="profile_image" id="profile_image" class="form-control">
                @if ($member->profile_image)
                    <img src="{{ asset('storage/' . $member->profile_image) }}" alt="Profile Image" width="100">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">อัปเดต</button>
        </form>
    </div>
</body>

</html>
