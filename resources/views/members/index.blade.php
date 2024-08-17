<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Member Management</h1>
        <a href="{{ route('members.create') }}" class="btn btn-primary mb-3">Add New Member</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ route('members.index') }}" method="GET">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="ค้นหาชื่อหรือสกุล"
                    value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>


        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>รูปภาพ</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>อายุ</th>
                    <th>วันเกิด</th>
                    <th>รายรับ</th>
                    <th>รายจ่าย</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td>
                            @if ($member->profile_image)
                                <img src="{{ $member->profile_image_url }}" alt="Profile Image" width="50">
                            @else
                                ไม่มีรูปภาพ
                            @endif
                        </td>
                        <td>{{ $member->first_name }}</td>
                        <td>{{ $member->last_name }}</td>
                        <td>{{ $member->age }}</td>
                        <td>{{ $member->birthdate }}</td>
                        <td>{{ $member->total_income }}</td>
                        <td>{{ $member->total_expense }}</td>
                        <td>

                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>


                            <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('คุณแน่ใจหรือว่าต้องการลบสมาชิกนี้?')">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">ไม่มีข้อมูลสมาชิก</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</body>

</html>
