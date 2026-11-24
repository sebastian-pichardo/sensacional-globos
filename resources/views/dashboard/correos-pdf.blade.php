<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        @page { margin: 28px 32px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; }
        h1 { margin: 0; font-size: 18px; color: #6b1a9b; }
        .meta { margin: 6px 0 16px; color: #6b7280; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #6b1a9b; color: #ffffff; text-align: left; padding: 7px 8px; font-size: 10px; }
        td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) td { background: #faf5ff; }
        .vacio { margin-top: 24px; color: #6b7280; }
    </style>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <p class="meta">
        Globos Sensacional ·
        {{ count($registros) }} {{ count($registros) === 1 ? 'correo' : 'correos' }} ·
        Generado el {{ $generado }}
    </p>

    @if (count($registros) === 0)
        <p class="vacio">No hay correos registrados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 36px;">#</th>
                    @foreach ($columnas as $columna)
                        <th>{{ $columna['etiqueta'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $indice => $registro)
                    <tr>
                        <td>{{ $indice + 1 }}</td>
                        @foreach ($columnas as $columna)
                            <td>{{ $registro[$columna['clave']] }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
