<?php

namespace App\Console\Commands;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class GenerarDocumentacion extends Command
{
    protected $signature = 'doc:generar {--output=docs/Documentacion_FitNova.pdf}';

    protected $description = 'Genera el PDF de documentación del proyecto (canvas, requerimientos, arquitectura y DER)';

    public function handle(): int
    {
        $pdf = Pdf::loadView('documentacion.proyecto');
        $output = $this->option('output');

        $directory = dirname(base_path($output));
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $pdf->save(base_path($output));

        $this->info('Documentación generada en: '.base_path($output));

        return self::SUCCESS;
    }
}
