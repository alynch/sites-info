@extends('layouts.app')

<style>
.grid {
    margin-top: 2em;
    display: grid;
    grid-template-columns: repeat(auto-fill, 20em);
    grid-gap: 1rem;
    justify-content: space-around;

}
</style>


@section('content')
<div class="grid">
        @foreach ($sites as $key => $site)
            <div class="card">
                <div class="card-header">
                    <span class="float-right">
                        @if ($site->status['running'])
                            OK
                        @else
                            Down
                        @endif
                    </span>
                    <h5 class="card-title">
                        {{ $site->name }}
                    </h5>
                    <a href="{{ $site->url }}">{{ $site->url }}</a>
                    <br/>
                    {{ $site->status['ip'] }}
                </div>

                @if (isset($site->status['details']))
                    <ul class="list-group list-group-flush">
                        @foreach ($site->status['details'] as $name => $values)
                            <li class="list-group-item">
                                {{ $name }}
                                <br/>
                                @if (isset($values['running']))
                                Running: {{ ($values['running'] == 'true')  }}
                                <br/>
                                @endif
                                @if (isset($values['version']))
                                Version: {{ $values['version'] }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @elseif (isset($site->status['headers']))
                    <ul class="list-group list-group-flush">
                        @foreach ($site->status['headers'] as $key => $value)
                            <li class="list-group-item">
                            {{ $key}}: {{ implode($value) }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="card-body">
                        No details available for this site.
                    </div>
                @endif
            <div>

            @if ($site->secondary->count())
	    <div class="card-header">
<h3>
		<button class="btn btn-link" type="button" data-toggle="collapse"
			data-target="#env{{$site->id}}" aria-expanded="false"
			aria-controls="collapseExample">
		Other environments
		  </button>
</h3>
		</div>
		<div class="collapse" id="env{{ $site->id }}">
            <div class="card-body">
                @foreach ($site->secondary as $environment)
                    <div>
                    <strong>{{ $environment->name }}:</strong>
                    {{ $environment->pivot->url }}
                    @if ($environment->status)
                        {{ ($environment->status['running']) ? 'OK' : 'Down' }}
                        <br/>
                        {{ $environment->status['ip'] }}
                        @if (isset($environment->status['headers']))
                        @foreach ($environment->status['headers'] as $key => $value) 
                            <li>
                            {{ $key}}: {{ implode($value) }}
                            </li>

                        @endforeach
                        @endif
                        <hr/>
                    @endif
                    </div>
                @endforeach
                </div>
                </div>
            @endif
            </div>
         </div>
       @endforeach
</div>
@endsection
