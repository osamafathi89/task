<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <form action='/transactionDetail' method="get">

        <div class="form-group">
            <label for="reciever">Reciever</label>
            <select class="form-control" id="reciever" name="id" >
                <option value="">Please Select</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    @if (isset($id)==$user->id)
                        @selected(true)
                    @endif
                    >{{ $user->name }}</option>
                @endforeach
            </select>

          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <label class="btn btn-info"> Transactions :{{isset($total[0]->total)?$total[0]->total:0}}</label>

            {{-- <a href={{ route('transaction.create') }}>New Transaction</a> --}}
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Process</th>
                    <th scope="col">Real money</th>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Excutive</th>
                    <th scope="col">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @if (isset($transactions))
                  @foreach ( $transactions as $transaction )
                  <tr>
                    <th scope="row">{{$transaction->id}}</th>
                    <td>{{$transaction->process}}</td>
                    <td>{{($transaction->realamount)}}</td>
                    <td>{{$transaction->effected_name}}</td>
                    <td>{{$transaction->reciever_name}}</td>
                    <td>{{$transaction->doner_name}}</td>
                    <td>{{($transaction->amount)}}</td>
                  </tr>
                  @endforeach
                  @endif

                </tbody>
              </table>

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        </div>
    </div>
</x-app-layout>
