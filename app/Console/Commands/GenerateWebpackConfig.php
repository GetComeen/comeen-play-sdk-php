<?php

namespace App\Console\Commands;

use App\Domain\Application\Model\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;



class GenerateWebpackConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:webpack-config
                            {app_id : applications\'s id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate webpack.config.js for the given application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $app = Application::find($this->argument('app_id'));
        $app->modules->each(function ($module) use ($app) {
            $lib = $app->type .'.'. $module->type .'.'. $module->identifier .'::'. $app->version;
            $path = $module->getOption('vue.component');

            $file = $app->getOption('path') .'/'. $module->identifier .'.webpack.config.js';
            $fp = fopen($file, 'w');
            fwrite($fp, $this->content($lib, $path));
            fclose($fp);

            echo "$file has been successfully generated for module $module->identifier (slide) ($app->name)\n";


            $path = $module->getOption('vue.options');

            $file = $app->getOption('path') .'/'. $module->identifier .'-options.webpack.config.js';
            $fp = fopen($file, 'w');
            fwrite($fp, $this->content($lib, $path));
            fclose($fp);

            echo "$file has been successfully generated for module $module->identifier (options) ($app->name)\n";
        });

        return $app->id;
    }

    public function entry($path)
    {
        $pathInfo = pathinfo($path);
        $name = $pathInfo['filename'];
        return  "{\n$name: path.resolve(__dirname, '$path'),\n}\n";
    }

    public function content($lib, $path)
    {
        return "const path = require('path');
        const { VueLoaderPlugin } = require('vue-loader')

        module.exports = {
          mode: 'development',
          entry: ". $this->entry($path) .",
          output: {
            path: path.resolve(__dirname, './dist'),
            publicPath: '/dist/',
            filename: '[name].js',
            library: ['$lib'],
            libraryTarget: 'window',
          },
          module: {
            rules: [
              {
                test: /\.vue$/,
                loader: 'vue-loader'
              },
              {
                test: /\.ts$/,
                loader: 'ts-loader',
                options: {
                  appendTsSuffixTo: [/\.vue$/],
                }
              },
              {
                test: /\.css$/,
                use: [
                  'style-loader',
                  'css-loader'
                ]
              }
            ]
          },
          resolve: {
            extensions: ['.ts', '.js', '.vue', '.json'],
            alias: {
              'vue': '@vue/runtime-dom',
              '@': 'src',
            }
          },
          plugins: [
            new VueLoaderPlugin()
          ],
          externals: {
          },
        }
        ";
    }
}
