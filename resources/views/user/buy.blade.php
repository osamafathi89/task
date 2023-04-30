<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

            <form action='/transaction' method="post">
                @csrf
                @method('POST')

                <div class="form-group">
                  <label for="exampleInputEmail1">Amount</label>
                  <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount">

                </div>
                <div class="form-group">
                    <label for="process">Process</label>
                    <select class="form-control" id="process" name="process" >
                        <option value="">Please Select</option>
                        <option value="charge">Charge</option>
                        <option value="withdraw">WithDraw</option>
                        <option value="transfer">transfer</option>
                    </select>

                  </div>
                  <div class="form-group">
                    <label for="effected">Effected</label>
                    <select class="form-control" id="effected" name="effected" >
                        <option value="">Please Select</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>

                  </div>

                  <div class="form-group">
                    <label for="reciever">Reciever</label>
                    <select class="form-control" id="reciever" name="reciever" >
                        <option value="">Please Select</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>

                  </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


            </div>
        </div>
    </div>
</x-app-layout>

