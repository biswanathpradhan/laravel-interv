<?php

use App\Models\Prize;

$current_probability = floatval(Prize::sum('probability'));
?>
<p class="alert alert-danger">Sum of all prizes probability must be 100%. Currently it's {{ $current_probability }}%. You have yet to add {{ 100-$current_probability }}% to the prize.</p>


@if(session('success'))
                        <p class="alert alert-success">
                            {!! session('success') !!}
                         </p>   
                    @endif

                    @if(session('error'))
                        <p class="alert alert-danger">
                            {!! session('error') !!}
                        </p>
         @endif
