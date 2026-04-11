<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Diagnóstico Hartman - {{ $result->guest_name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #3b82f6;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0;
        }
        .meta {
            margin-bottom: 30px;
            font-size: 14px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 25px;
            margin-bottom: 15px;
            border-left: 4px solid #3b82f6;
            padding-left: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .interpretation {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            text-align: center;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .warning {
            color: #b91c1c;
            font-style: italic;
            margin-top: 10px;
        }
        /* Markdown-like styling for PDF */
        .diagnosis-content h1, .diagnosis-content h2, .diagnosis-content h3 { color: #1e3a8a; }
        .diagnosis-content p { margin-bottom: 10px; }
        .diagnosis-content ul { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Reporte de Diagnóstico Axiológico</h1>
        <p>Hartman Value Profile (HVP)</p>
    </div>

    <div class="meta">
        <p><strong>Fecha:</strong> {{ $date }}</p>
        <p><strong>Evaluado:</strong> {{ $result->guest_name }}</p>
    </div>

    <div class="section-title">Sobre el Test de Hartman</div>
    <p style="font-size: 13px; text-align: justify;">
        El Hartman Value Profile (HVP) es una herramienta científica basada en la axiología formal (la ciencia del valor). 
        No mide rasgos de personalidad, sino la estructura del pensamiento evaluativo del individuo: cómo percibe y asigna valor 
        tanto al mundo exterior como a sí mismo. Analiza tres dimensiones fundamentales: el valor Intrínseco (personas y singularidad), 
        el Extrínseco (roles y tareas) y el Sistémico (conceptos y normas).
    </p>

    <div class="section-title">Resultados de las Variables</div>
    <table>
        <thead>
            <tr>
                <th>Variable</th>
                <th>Parte 1: El Mundo</th>
                <th>Parte 2: El Yo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $variables = [
                    'DIF' => 'Desviación Total (DIF)',
                    'DIM_I' => 'Dimensión Intrínseca (I)',
                    'DIM_E' => 'Dimensión Extrínseca (E)',
                    'DIM_S' => 'Dimensión Sistémica (S)',
                    'Dim' => 'Diferenciación (Dim)',
                    'Int' => 'Integración (Int)',
                    'Dis' => 'Disonancia (Dis)',
                    'DimP' => 'Diferenciación %',
                    'IntP' => 'Integración %',
                    'AIP' => 'Axiological Insight %',
                    'Rho' => 'Correlación (Rho)'
                ];
            @endphp
            @foreach($variables as $key => $label)
                <tr>
                    <td style="text-align: left; font-weight: bold;">{{ $label }}</td>
                    <td>{{ number_format($result->scores['part_1'][$key] ?? 0, 2) }}</td>
                    <td>{{ number_format($result->scores['part_2'][$key] ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Diagnóstico del Agente IA</div>
    <div class="interpretation diagnosis-content">
        {!! Illuminate\Support\Str::markdown($aiInterpretation) !!}
    </div>

    <div class="footer">
        <p>¡Gracias por confiar en Quality & Competitive College para su desarrollo profesional!</p>
        <p class="warning">
            <strong>ADVERTENCIA:</strong> Este reporte es una herramienta de orientación generada mediante inteligencia artificial. 
            Debe ser interpretado por un profesional certificado en la metodología Hartman para decisiones críticas de contratación o desarrollo.
        </p>
        <p>&copy; {{ date('Y') }} Quality & Competitive College (QCC). Todos los derechos reservados.</p>
    </div>
</body>
</html>
