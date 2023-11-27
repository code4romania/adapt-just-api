<table>
    <tbody>
        <tr>
            <td></td>
            <td>
                <table>
                    <tr>
                        <td>Mesaj receptionat de la <strong>{{ $data['first_name'] }} {{ $data['last_name'] }}</strong> prin formularul de contact</td>
                    </tr>
                    <tr>
                        <td>Adresa de email: <strong>{{ $data['email'] }}</strong></td>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                {{ $data['message'] }}
            </td>
            <td></td>
        </tr>
    </tbody>
</table>

