<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class FixPostTexts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix-post-texts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix post markup';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Post::get()->each(function(Post $post) {
            $post->text = $this->clean($post->text);

            $post->save();
        });
    }

    public function clean(string $text): string
    {
        $text = str_replace('<pre><code class="js">', '```js' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="bash">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="php">', '```php' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="txt">', '```txt' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="html">', '```html' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="yaml">', '```yaml' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="js">', '```js' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="bash">', '```bash' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="php">', '```php' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="txt">', '```txt' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="html">', '```html' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="yaml">', '```yaml' . PHP_EOL, $text);

        $text = str_replace('<pre><code>', '```' . PHP_EOL, $text);

        $text = str_replace('</code></pre>', PHP_EOL . '```' . PHP_EOL, $text);

        $text = str_replace('</code>', '`', $text);

        $text = str_replace('<code>', '`', $text);

        $text = str_replace('</code>', '`', $text);

        $text = str_replace('[code lang="php"]', '```php'.PHP_EOL, $text);

        $text = str_replace('[/code]', '```' . PHP_EOL, $text);

        $text = str_replace('&gt;', '>', $text);

        return str_replace('&lt;', '<', $text);
    }
}
