<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statement') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-3">
                        <div class="card">
                            <h5 class="card-header">Statement of account</h5>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DateTime</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Details</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at }}</td>
                                                <td>{{ $transaction->amount }}</td>
                                                <td>{{ $transaction->type }}</td>
                                                <td>
                                                    @if ($transaction->sender_account_id && $transaction->receiver_account_id)
                                                        Transfer from {{$transaction->senderAccount->user->name}} to {{$transaction->receiverAccount->user->name}}
                                                    @elseif ($transaction->receiver_account_id != null)
                                                        Deposit
                                                    @else
                                                        Withdraw
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->after_balance }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
