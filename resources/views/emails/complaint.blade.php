<table>
    @if ($complaint->victim == \App\Constants\ComplaintConstant::VICTIM_ME)
        <tr>
            <td></td>
            <td>
                Subsemnata/Subsemnatul {{ $complaint->name }}
                @if (!empty($complaint->county_name) || !empty($complaint->location_name))
                    , mă aflu în
                    @if (!empty($complaint->county_name)) {{ strtoupper($complaint->county_name) }} @endif
                    @if (!empty($complaint->location_name))  în {{ strtoupper($complaint->location_name) }} @endif
                @endif
                , și declar că:
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                @if ($complaint->type == \App\Constants\ComplaintConstant::TYPE_HURT)
                    <ul>
                        @foreach($complaint->getDetailLabels() as $d)
                            <li>{{ $d }}</li>
                        @endforeach
                    </ul>
                @endif

                @if ($complaint->type == \App\Constants\ComplaintConstant::TYPE_MOVE)
                    <ul>
                        <li>Vreau sa fiu mutat/a la
                            @if (!empty($complaint->location_to_name))
                                {{ $complaint->location_to_name }}
                            @else
                                alt centru
                            @endif
                        </li>
                    </ul>
                    @if (!empty($complaint->reason))
                        <p>Motivul pentru care vreau să mă mut este {{ $complaint->reason }}</p>
                    @endif
                @endif

                @if ($complaint->type == \App\Constants\ComplaintConstant::TYPE_EVALUATION)
                    <ul>
                        <li>Vreau să fiu evaluat/ă din nou la judecător</li>
                    </ul>
                @endif
            </td>
            <td></td>
        </tr>
    @endif

    @if ($complaint->victim == \App\Constants\ComplaintConstant::VICTIM_OTHER)
        <tr>
            <td></td>
            <td>
                Subsemnata/Subsemnatul {{ $complaint->name }}, declar ca
                @if (!empty($complaint->county_name) || !empty($complaint->location_name))
                    @if (!empty($complaint->county_name))
                        {{ strtoupper($complaint->county_name) }}
                    @endif
                    @if (!empty($complaint->location_name))
                        în {{ strtoupper($complaint->location_name) }},
                    @endif
                @endif
                s-au întâmplat următoarele
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <ul>
                    <li>{{ $complaint->reason }}</li>
                </ul>
            </td>
            <td></td>
        </tr>
    @endif
    <tr>
        <td></td>
        <td>
            <p>Solicit ca datele mele personale să nu devină publice ca urmare a acestei plângeri, a cărei soluționare o cer.</p>
        </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>
            @if ($complaint->proof_type == \App\Constants\ComplaintConstant::PROOF_TYPE_YES)
                <p>Am atașat plângerii următoarele dovezi</p>
                <ul>
                    @foreach($complaint->uploads as $upload)
                        <li>
                            <a target="_blank" href="{{ \Illuminate\Support\Facades\URL::signedRoute('uploads.show', ['uploadHashName' => $upload->hash_name]) }}">
                                {{ $upload->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if ($complaint->proof_type == \App\Constants\ComplaintConstant::PROOF_TYPE_LATER)
                <p>Am dovezi si pot fi oferite daca imi vor fi cerute mai tarziu.</p>
            @endif
        </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>
            SEMNAT,<br>
            {{ strtoupper($complaint->name) }}
        </td>
        <td></td>
    </tr>
</table>

