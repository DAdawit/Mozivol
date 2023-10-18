<form action="{{ route('login.as',Crypt::encrypt($id)) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-sm bg-green">
        <i class="fa fa-key"></i>
    </button>
</form>