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
                            {app-id : applications\'s id}';

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
        $app = Application::find($this->argument('app-id'));
        $file = $app->getOption('path') .'/webpack.config.js';
        $fp = fopen($file, 'w');
        fwrite($fp, $this->content($app));
        fclose($fp);


        echo "webpack.config.js has been successfully generated for application $app->name\n";

        return $app->id;
    }

    public function entries(Application $app) {
        $entries = "{\n";
        $app->modules->each(function ($module) use (&$entries) {
            $path = $module->getOption('vue.component');
            $pathInfo = pathinfo($path);
            $name = $pathInfo['filename'];
            $entries .=  "    $name: path.resolve(__dirname, '$path'),\n";

            $path = $module->getOption('vue.options');
            $pathInfo = pathinfo($path);
            $name = $pathInfo['filename'];
            $entries .=  "    $name: path.resolve(__dirname, '$path'),\n";
        });
        $entries .= "  }";
        return $entries;
    }

    public function content(Application $app)
    {
        return "const path = require('path');
        const { VueLoaderPlugin } = require('vue-loader')

        module.exports = {
          mode: 'development',
          entry: ". $this->entries($app) .",
          output: {
            path: path.resolve(__dirname, './dist'),
            publicPath: '/dist/',
            filename: '[name].js',
            library: ['DynamicScreenLibrary'],
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
            vue: 'Vue',
          },
        }
        ";
    }
}
