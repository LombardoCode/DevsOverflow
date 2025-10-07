<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // Crear roles y permisos
    Role::create(['name' => 'administrador']);
    Permission::create(['name' => 'crear-categorias']);

    // Crear usuarios específicos
    $lombardo = User::create([
      'name' => 'lombardo',
      'email' => 'lombardo@devsoverflow.com',
      'password' => bcrypt('password'),
      'description' => 'DevsOverflow Administrator'
    ]);
    $lombardo->assignRole('administrador');
    $lombardo->givePermissionTo('crear-categorias');

    $john = User::create([
      'name' => 'john',
      'email' => 'john@devsoverflow.com',
      'password' => bcrypt('password'),
      'description' => 'Full stack developer passionate for Laravel and Linux'
    ]);

    $tom = User::create([
      'name' => 'tom',
      'email' => 'tom@devsoverflow.com',
      'password' => bcrypt('password'),
      'description' => 'Frontend developer with expertise in modern web development'
    ]);

    $robert = User::create([
      'name' => 'robert',
      'email' => 'robert@devsoverflow.com',
      'password' => bcrypt('password'),
      'description' => 'Backend developer with expertise in Laravel and databases'
    ]);

    // Create categories
    $linux = Categoria::create([
      'categoria' => 'Linux',
      'descripcion' => 'Open source operating system'
    ]);

    $webDev = Categoria::create([
      'categoria' => 'Web Development',
      'descripcion' => 'Modern web application development'
    ]);

    $laravel = Categoria::create([
      'categoria' => 'Laravel',
      'descripcion' => 'PHP Framework for Web Artisans'
    ]);

    // Linux questions
    $linuxQuestions = [
      [
        'user_id' => $john->id,
        'pregunta' => 'How to change file permissions in Linux?',
        'descripcion' => 'Need to understand how file permissions work',
        'contenido_html' => '<p>I\'m trying to change the permissions of a file but I don\'t know what command to use. Can someone explain how permissions work in Linux and what numbers like 755 or 644 mean?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $tom->id,
        'pregunta' => 'What is the difference between apt and apt-get?',
        'descripcion' => 'Confusion between package managers in Ubuntu',
        'contenido_html' => '<p>I\'ve seen that in Ubuntu I can use both <code>apt</code> and <code>apt-get</code> to install packages. What\'s the difference? Which one should I use?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $lombardo->id,
        'pregunta' => 'How to find processes consuming high CPU?',
        'descripcion' => 'System performance monitoring',
        'contenido_html' => '<p>My Linux server is running slow and I need to identify which processes are consuming the most resources. What command can I use to see this in real-time?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $john->id,
        'pregunta' => 'How to configure passwordless SSH?',
        'descripcion' => 'SSH authentication with public keys',
        'contenido_html' => '<p>I want to connect to my server without having to type the password every time. I\'ve heard about SSH keys but I don\'t know how to configure them. Can anyone help me?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $tom->id,
        'pregunta' => 'How to compress and decompress tar.gz files?',
        'descripcion' => 'Working with compressed files in Linux',
        'contenido_html' => '<p>I always get confused with the <code>tar</code> parameters. What\'s the correct way to compress and decompress .tar.gz files in Linux?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
    ];

    // Web Development questions
    $webDevQuestions = [
      [
        'user_id' => $tom->id,
        'pregunta' => 'What is the difference between let, const and var in JavaScript?',
        'descripcion' => 'Understanding variable scope in JavaScript',
        'contenido_html' => '<p>I\'m learning modern JavaScript and I\'m confused about the differences between <code>let</code>, <code>const</code> and <code>var</code>. When should I use each one?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $john->id,
        'pregunta' => 'How to create a REST API with JWT authentication?',
        'descripcion' => 'Implementing authentication in APIs',
        'contenido_html' => '<p>I need to create a secure REST API with JWT authentication. What are the best practices to implement this? Where should I store the token on the frontend?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $lombardo->id,
        'pregunta' => 'Responsive design with CSS Grid or Flexbox?',
        'descripcion' => 'Choosing the best option for responsive layouts',
        'contenido_html' => '<p>I\'m designing a responsive website and I don\'t know whether to use CSS Grid or Flexbox. What are the advantages of each? Can they be combined?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $tom->id,
        'pregunta' => 'How to optimize web application performance?',
        'descripcion' => 'Improving my site loading speed',
        'contenido_html' => '<p>My web application is loading very slowly. What techniques can I use to improve performance? I\'ve heard about lazy loading, code splitting, etc. Where should I start?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $john->id,
        'pregunta' => 'What is CORS and how to fix it?',
        'descripcion' => 'Cross-origin policy issues',
        'contenido_html' => '<p>I\'m getting CORS errors when trying to make requests to my API from the frontend. What exactly is CORS and how can I configure it correctly on the server?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
    ];

    // Laravel questions
    $laravelQuestions = [
      [
        'user_id' => $lombardo->id,
        'pregunta' => 'How to pass data from controller to Blade view?',
        'descripcion' => 'Sending variables to templates',
        'contenido_html' => '<p>I need to send data from my controller to a Blade template. What\'s the correct way to pass variables and make them available in the view?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $john->id,
        'pregunta' => 'How to create foreign keys in Laravel migrations?',
        'descripcion' => 'Database relationships with migrations',
        'contenido_html' => '<p>I\'m creating a migration and need to add a foreign key that references another table. What\'s the correct syntax to define foreign keys and cascade deletes?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $tom->id,
        'pregunta' => 'How to implement upvote/downvote system in Laravel?',
        'descripcion' => 'Vote tracking with database',
        'contenido_html' => '<p>I want to create a voting system where users can upvote or downvote posts. How do I track votes in the database and prevent duplicate votes from the same user?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $lombardo->id,
        'pregunta' => 'How to use @extends and @section in Blade templates?',
        'descripcion' => 'Template inheritance in Blade',
        'contenido_html' => '<p>I\'m trying to understand template inheritance in Laravel. How do @extends, @section, and @yield work together? Can someone explain with a practical example?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
      [
        'user_id' => $john->id,
        'pregunta' => 'How to create a notification system in Laravel?',
        'descripcion' => 'Implementing user notifications',
        'contenido_html' => '<p>I need to notify users when someone replies to their post. How do I create a notification system that tracks events and shows unread notification counts?</p>',
        'identificador' => \Illuminate\Support\Str::random(10),
      ],
    ];

    // Insert questions and relationships
    $linuxQuestionsCreated = [];
    foreach ($linuxQuestions as $questionData) {
      $question = \App\Models\Pregunta::create($questionData);
      \App\Models\RelacionCategoriaPregunta::create([
        'categoria_id' => $linux->id,
        'pregunta_id' => $question->id
      ]);
      $linuxQuestionsCreated[] = $question;
    }

    $webDevQuestionsCreated = [];
    foreach ($webDevQuestions as $questionData) {
      $question = \App\Models\Pregunta::create($questionData);
      \App\Models\RelacionCategoriaPregunta::create([
        'categoria_id' => $webDev->id,
        'pregunta_id' => $question->id
      ]);
      $webDevQuestionsCreated[] = $question;
    }

    $laravelQuestionsCreated = [];
    foreach ($laravelQuestions as $questionData) {
      $question = \App\Models\Pregunta::create($questionData);
      \App\Models\RelacionCategoriaPregunta::create([
        'categoria_id' => $laravel->id,
        'pregunta_id' => $question->id
      ]);
      $laravelQuestionsCreated[] = $question;
    }

    // Create answers for Linux questions
    \App\Models\Respuesta::create([
      'user_id' => $robert->id,
      'pregunta_id' => $linuxQuestionsCreated[0]->id,
      'contenido_html' => '<p>You can use the chmod command to change file permissions. The numbers represent owner, group, and other permissions. Each digit is calculated as Read(4) + Write(2) + Execute(1). For example, 755 means owner can read/write/execute, while group and others can only read/execute.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $lombardo->id,
      'pregunta_id' => $linuxQuestionsCreated[1]->id,
      'contenido_html' => '<p>apt is a newer, more user-friendly interface that combines the most commonly used commands from apt-get and apt-cache. apt has a progress bar and colored output, and is designed for interactive use. apt-get is better for scripts due to its stable interface. For daily use, I recommend apt. For scripts, use apt-get.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $john->id,
      'pregunta_id' => $linuxQuestionsCreated[2]->id,
      'contenido_html' => '<p>Use the top or htop command for real-time process monitoring. top is available by default on most systems. Press Shift+P to sort by CPU usage, Shift+M to sort by memory usage, and q to quit. For a better experience, install htop. Another useful command is ps aux to see top CPU consumers.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $tom->id,
      'pregunta_id' => $linuxQuestionsCreated[3]->id,
      'contenido_html' => '<p>To set up SSH key authentication: Generate an SSH key pair on your local machine using ssh-keygen. Copy your public key to the server using ssh-copy-id. Set the correct permissions on the server for the .ssh directory and authorized_keys file. Now you can SSH without a password!</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $robert->id,
      'pregunta_id' => $linuxQuestionsCreated[4]->id,
      'contenido_html' => '<p>To compress files, use tar -czf archive.tar.gz /path/to/directory. To decompress, use tar -xzf archive.tar.gz. The flags mean: c for create, x for extract, z for gzip compression, f for filename, and v for verbose output.</p>',
      'mejor_respuesta' => false
    ]);

    // Create answers for Web Development questions
    \App\Models\Respuesta::create([
      'user_id' => $john->id,
      'pregunta_id' => $webDevQuestionsCreated[0]->id,
      'contenido_html' => '<p>var is function-scoped and can be redeclared. let is block-scoped and cannot be redeclared. const is also block-scoped and cannot be redeclared or reassigned. Best practice: Use const by default, use let only when you need to reassign, and avoid var in modern JavaScript.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $robert->id,
      'pregunta_id' => $webDevQuestionsCreated[1]->id,
      'contenido_html' => '<p>For JWT authentication: Generate JWT on login with expiration. Store the token in an httpOnly cookie for maximum security, or localStorage for easier implementation. Implement a refresh token mechanism for better security. Always validate the token on the server before processing requests. Never store sensitive data in JWT payload as it is encoded, not encrypted!</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $tom->id,
      'pregunta_id' => $webDevQuestionsCreated[2]->id,
      'contenido_html' => '<p>Both are powerful and can be combined! Use Flexbox when working with one-dimensional layouts, distributing items along a single axis, or aligning items within a container. Use CSS Grid when working with two-dimensional layouts, creating complex page layouts, or when you need precise control over both axes. Common pattern: Use Grid for page layout and Flexbox for components inside grid cells!</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $robert->id,
      'pregunta_id' => $webDevQuestionsCreated[3]->id,
      'contenido_html' => '<p>Key optimization techniques include: Compress images and use modern formats like WebP with lazy loading. Implement code splitting to load only necessary JavaScript for each page. Minify CSS, JS, and HTML. Implement browser caching with proper headers. Use a CDN for static assets. Analyze and reduce bundle size. Start by running a Lighthouse audit in Chrome DevTools to identify bottlenecks!</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $robert->id,
      'pregunta_id' => $webDevQuestionsCreated[4]->id,
      'contenido_html' => '<p>CORS (Cross-Origin Resource Sharing) is a security feature that restricts web pages from making requests to a different domain. On the server side, you can use the cors middleware in Express or manually set headers like Access-Control-Allow-Origin. For production, always specify allowed origins instead of using wildcards!</p>',
      'mejor_respuesta' => false
    ]);

    // Create answers for Laravel questions
    \App\Models\Respuesta::create([
      'user_id' => $robert->id,
      'pregunta_id' => $laravelQuestionsCreated[0]->id,
      'contenido_html' => '<p>In Laravel, you can pass data to Blade views using the view helper function. Return view with an array of data, or use the compact function. For example: return view("my-view", ["title" => "My Page", "user" => $user]). In the Blade template, access these variables directly like {{ $title }} or {{ $user->name }}. This is the standard way to send data from controllers to views.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $lombardo->id,
      'pregunta_id' => $laravelQuestionsCreated[1]->id,
      'contenido_html' => '<p>Use the foreign method in your migration to create foreign keys. First define the column with unsignedBigInteger, then add the foreign key constraint. For example: $table->unsignedBigInteger("user_id"); followed by $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade"). The onDelete cascade ensures that when the parent record is deleted, all related child records are also deleted automatically.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $john->id,
      'pregunta_id' => $laravelQuestionsCreated[2]->id,
      'contenido_html' => '<p>Create a votes table with user_id and post_id as a composite key to prevent duplicate votes. In your controller, check if a vote exists using where clauses for both user and post. If it exists and the user clicks the same button, delete the vote. If they click the opposite button, update the vote. Count positive and negative votes separately using where with the vote boolean field. This ensures each user can only vote once per post.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $tom->id,
      'pregunta_id' => $laravelQuestionsCreated[3]->id,
      'contenido_html' => '<p>Blade template inheritance works with three directives: @extends specifies the parent layout, @section defines content blocks, and @yield in the parent marks where content goes. For example, create a layout with @yield("content"), then in child views use @extends("layouts.main") and @section("content") to fill that area. The @stop or @endsection closes each section. This allows you to reuse common layouts across multiple pages.</p>',
      'mejor_respuesta' => false
    ]);

    \App\Models\Respuesta::create([
      'user_id' => $robert->id,
      'pregunta_id' => $laravelQuestionsCreated[4]->id,
      'contenido_html' => '<p>Create a notifications table to store notification events. When an action occurs (like a new reply), insert a record with the user to notify, the event type, and related IDs. Use a separate table to link notifications with specific content. In your controller, query notifications for the current user ordered by date, limit to recent ones, and count unread notifications with a boolean field. Display the count in your navbar and mark as read when the user views them.</p>',
      'mejor_respuesta' => false
    ]);
  }
}
