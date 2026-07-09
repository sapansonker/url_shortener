<form action="{{ route('company.store') }}" method="POST">
    @csrf

    <label>Company Name</label>

    <input
        type="text"
        name="company_name"
    >

    <br><br>

    <label>Admin Name</label>

    <input
        type="text"
        name="admin_name"
    >

    <br><br>

    <label>Admin Email</label>

    <input
        type="email"
        name="email"
    >

    <br><br>

    <label>Password</label>

    <input
        type="password"
        name="password"
    >

    <br><br>

    <button type="submit">
        Create Company
    </button>

</form>