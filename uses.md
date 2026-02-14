# My current setup (2026 edition)

After posting a screenshot, I often get questions about which editor, font or tools I'm using. Instead of replying to those questions individually I've decided to just write down the settings and apps that I'm using.

## IDE

[Claude Code](https://claude.ai/code) is my primary coding agent. I run it in iTerm2 and it handles the heavy lifting: writing features, running tests, debugging. My role has shifted to reviewing, guiding, and polishing.

![Screenshot of Zed editor](TODO_ZED_SCREENSHOT)

[Zed](https://zed.dev) is my main editor. It's fast and gets out of the way. I use the One Light theme with [JetBrains Mono](https://fonts.google.com/specimen/JetBrains+Mono) (size 15, line height 1.7) for the editor and [MesloLGM Nerd Font Mono](https://www.nerdfonts.com/font-downloads) for the integrated terminal. Formatting on save is handled by Laravel Pint. I've stripped the UI down to the essentials: no tab bar, no minimap, no git blame, most panel buttons hidden. Copilot edit predictions are enabled though.

[PhpStorm](https://www.jetbrains.com/phpstorm/) is still around for major refactoring sessions where I need powerful find-and-replace across hundreds of files.

## Terminal

![Screenshot of iTerm2 terminal](TODO_TERMINAL_SCREENSHOT)

I use [iTerm2](https://iterm2.com) with Z shell and [Oh My Zsh](https://ohmyz.sh). The prompt is a customized agnoster theme.

I've replaced most traditional CLI tools with faster, modern alternatives:

- [eza](https://eza.rocks) instead of `ls` (with icons and tree view)
- [bat](https://github.com/sharkdp/bat) instead of `cat` (syntax highlighting)
- [ripgrep](https://github.com/BurntSushi/ripgrep) instead of `grep`
- [fd](https://github.com/sharkdp/fd) instead of `find`
- [zoxide](https://github.com/ajeetdsouza/zoxide) instead of `cd` (smart directory jumping)
- [delta](https://github.com/dandavella/delta) as my git pager (side-by-side diffs)
- [fnm](https://github.com/Schniz/fnm) instead of `nvm` (fast Node.js version management)

Some aliases I can't live without:

```bash
alias a="php artisan"
alias mfs="php artisan migrate:fresh --seed"
alias nah="git reset --hard;git clean -df"
```

I also have a [`commit()` function](https://freek.dev/2978-how-to-automatically-generate-a-commit-message-using-claude) that uses Claude to auto-generate commit messages from the current diff.

## Dotfiles

Most of my development setup is version-controlled in my public [dotfiles repository](https://github.com/freekmurze/dotfiles). It contains my shell configuration, editor settings, Claude Code configuration, aliases, functions, and more. If you want to replicate anything you see in this post, that repo is the place to start.

## macOS

![Screenshot of my macOS desktop](TODO_MACOS_DESKTOP_SCREENSHOT)

By default I hide the menu bar and dock. I like to keep my desktop ultra clean, even hard disks aren't allowed to be displayed there. On my dock there aren't any sticky programs. Only apps that are running are on there. I only have stacks to Downloads and Desktop permanently on there. I've also hidden the indicator for running apps (that dot underneath each app), because if it's on my dock it's running.

[The spacey background I'm using](https://512pixels.net/downloads/macos-wallpapers/10-6-Server.png) was the default one on Mac OS X 10.6 Snow Leopard Server.

One of the most important apps that I use is [Raycast](https://www.raycast.com). It allows me to quickly do basic tasks such as opening up apps, locking my computer, emptying the trash, and much more. One of the best built in functions is the clipboard history. By default, macOS will only hold one thing in your clipboard, with Raycast I have a seemingly unending history of things I've copied, and the clipboard even survives a restart. It may sound silly, but I find myself using the clipboard history multiple times a day, it's that handy.

![Screenshot of Raycast](TODO_RAYCAST_SCREENSHOT)

Raycast is also a window manager. I often work with two windows side by side: one on the left part of the screen, the other one on the right. I've configured Raycast with these window managing shortcuts:

- ctrl+opt+cmd+arrow left: resize active window to the left half of the screen
- ctrl+opt+cmd+arrow right: resize active window to the right half of the screen
- ctrl+opt+cmd+arrow up: resize active window to take the whole screen

I've installed these Raycast extensions:

- [Zed](https://www.raycast.com/ewgenius/zed-recent-projects): open up a Zed project from anywhere
- [JetBrains Toolbox Recent Projects](https://www.raycast.com/gdsmith/jetbrains): same thing for PhpStorm
- [Laravel Docs](https://www.raycast.com/indykoning/laravel-docs): search the Laravel docs from anywhere
- [Laravel Livewire](https://www.raycast.com/tafhyseni/laravel-livewire): search the Livewire docs
- [Pest Documentation](https://www.raycast.com/danyelkeddah/pestphp-documentation): same purpose for Pest
- [Spatie Documentation](https://www.raycast.com/danyelkeddah/spatie-documentation): search the docs for our own packages
- [Tailwind CSS](https://www.raycast.com/vimtor/tailwindcss): you guessed it: search the Tailwind docs
- [Tuple](https://www.raycast.com/inxilpro/tuple): start a Tuple call with one of my colleagues
- [TablePlus](https://www.raycast.com/pernielsentikaer/tableplus): open database connections
- [1Password](https://www.raycast.com/khasbilegt/1password): search and open passwords
- [Kill Process](https://www.raycast.com/rolandleth/kill-process): kill a misbehaving process
- [Emoji Search](https://www.raycast.com/FezVrasta/emoji): search and paste emoji
- [Coffee](https://www.raycast.com/mooxl/coffee): prevent my Mac from sleeping

These are some of the other apps I'm using:

- To run projects locally I use [Laravel Valet](https://laravel.com/docs/valet). [PHP Monitor](https://phpmon.app) keeps track of my PHP versions alongside it.
- [Ray](https://myray.app) is our own little tool at Spatie that I use for debugging apps. I use it daily.
- Sometimes I need to run an arbitrary piece of PHP code. [CodeRunner](https://coderunnerapp.com) is an excellent app to do just that.
- [Yaak](https://yaak.app) is my go-to for performing API calls. It's simple, it's good.
- Databases are managed with [TablePlus](https://tableplus.com), and I use [DBngin](https://dbngin.com) to manage local database servers.
- For Docker and Linux machines I use [OrbStack](https://orbstack.dev). It's way faster and lighter than regular Docker.
- [ImageOptim](https://imageoptim.com) compresses images before I commit them.
- If you're not using a password manager, you're doing it wrong. I use [1Password](https://1password.com). It also handles SSH key signing via its SSH agent.
- [Things](https://culturedcode.com/things/) contains my to-dos.
- [Hidden Bar](https://github.com/dwarvesf/hidden) hides menu bar clutter.
- [CleanShot X](https://cleanshot.com) handles screenshots and screen recording.
- [DaisyDisk](https://daisydiskapp.com) is a nice app that helps you determine how your disk space is being used.
- My favourite cloud storage solution is [Dropbox](https://dropbox.com). It's an oldie, but still good.
- I read a lot of blogs through RSS feeds in [Reeder](https://reederapp.com).
- Mails are read and written in [Mimestream](https://mimestream.com). Unlike other email clients which rely on IMAP, Mimestream uses the full Gmail API. It's super fast, and the author is dedicated to using the latest stuff in macOS. It's a magnificent app really.
- My browser of choice is [Safari](https://www.apple.com/safari/), because of its speed and low power usage. To block ads I use [1Blocker](https://1blocker.com).
- I like to write long blog posts in [iA Writer](https://ia.net/writer).
- To pair program with anyone in my team, I use [Tuple](https://tuple.app). The quality of the shared screen and sound is fantastic.
- For team communication at Spatie we use [Slack](https://slack.com). For personal messaging I use [Telegram](https://telegram.org) and [WhatsApp](https://whatsapp.com).
- I have both [Claude](https://claude.ai) and [ChatGPT](https://chatgpt.com) as desktop apps for when I need AI assistance outside the terminal.
- [OpenClaw](https://openclaw.ai) is an AI agent I deployed on a Digital Ocean server that I use via Telegram. It posts interesting links on my blog, summarizes blog posts for me, and helps me create code snippet screenshots. I've just started using it and I think I'll have more use cases for it next year. Fantastic technology.

## iOS

Here's a screenshot of my current homescreen.

![Screenshot of my iPhone homescreen](TODO_IPHONE_SCREENSHOT)

I don't use folders and try to keep the number of installed apps to a minimum. There's just one screen with apps, all the other apps are opened via search. Notifications and notification badges are turned off for all apps except Messages. My current phone is an iPhone 17 Pro Max.

In the dock I have Mail, Messages, [Claude](https://apps.apple.com/app/claude/id6743908814), and Safari.

Here's a rundown of the apps on the homescreen:

- I listen to podcasts using Apple's built-in [Podcasts](https://apps.apple.com/app/apple-podcasts/id525463029) app.
- [WordStockt](https://freek.dev/2983-i-built-a-native-mobile-word-game-in-two-weeks) is a word game I built myself. I play it daily.
- [WhatsApp](https://whatsapp.com) and [Telegram](https://telegram.org) are where most of my friends and family are, so I need both.
- I live in Antwerp, fantastic city. I don't own a car and do almost everything by bike and foot. [Velo Antwerpen](https://www.velo-antwerpen.be) is the local bike sharing service and great for getting around.
- [Slack](https://slack.com) is for communicating with my team and some other communities.
- [Google Drive](https://drive.google.com) gives me file access on the go.
- [Letterboxd](https://letterboxd.com) is like a pretty version of IMDb. I use it to log every movie I watch.
- My home is full of HomeKit controlled lights and a [Nuki](https://nuki.io) lock, which I control using the Home app.
- [VRT MAX](https://www.vrt.be/vrtmax/) is a Belgian streaming service.
- We use [Asana](https://asana.com) for project management at Spatie.
- [Reeder](https://reederapp.com) is where I read all my RSS feeds.
- [SNCB](https://www.belgiantrain.be) is handy for looking up train schedules in Belgium.
- [Dropbox](https://dropbox.com) keeps my files accessible everywhere.
- [Nuki](https://nuki.io) controls the electronic door lock at our home.
- I use [Books](https://apps.apple.com/app/apple-books/id364709193) for reading on the go.
- I still use [X](https://x.com) (Twitter), mostly through the website on Mac. I still miss [Tweetbot](https://tapbots.com/tweetbot/) a lot.
- [Bluesky](https://bsky.app) is the new social network. I'm on there too.
- For music I use [Apple Music](https://www.apple.com/apple-music/).

There are no other screens set up. I use the App Library to find any app that isn't on the home screen.

## Hardware

![Screenshot of About This Mac](TODO_MACOS_SCREENSHOT)

I'm using a MacBook Pro 16-inch with an Apple M4 Pro processor, 48 GB of RAM, running macOS Tahoe.

I usually work in closed-display mode. To save some desk space, I use a vertical Mac stand: the [Twelve South BookArc](https://www.twelvesouth.com/products/bookarc-for-macbook). The external monitor is a [Gigabyte Aorus FO32U2P](https://www.gigabyte.com/Monitor/AORUS-FO32U2P), a 32" 4K OLED.

Here's the hardware that is on my desk:

- a space grey wireless Apple Magic Keyboard with Touch ID
- a space grey Apple Magic Trackpad

To connect all external hardware to my MacBook I have a [CalDigit TS3 Plus](https://www.caldigit.com/ts3-plus/). This allows me to connect everything to my MacBook with a single USB-C cable. That cable also charges the MacBook. Less clutter on the desk means more headspace.

I play music on a [KEF LS50 Wireless II](https://www.kef.com/products/ls50-wireless-ii) stereo pair, which sound incredible. To stay in "the zone" when commuting or at the office have my [Sony WH-1000XM6](https://www.sony.com/headphones/wh-1000xm6) noise-cancelling headphones.

Next to programming, my big passion is music. I produce tracks under my artist name [Kobus](https://freek.dev/music). You can find my music on Spotify and Apple Music. I use [Ableton Live 12 Suite](https://www.ableton.com) for recording and editing.

## Misc

At [Spatie](https://spatie.be), we use [Google Workspace](https://workspace.google.com) to handle mail and calendars. High level planning at the company is done using [Float](https://www.float.com). All servers I work on are provisioned by [Forge](https://forge.laravel.com). The performance and uptime of those servers are monitored via [Oh Dear](https://ohdear.app). To track exceptions in production, we use [Flare](https://flareapp.io). To send mails to our audience that is interested in [our paid products](https://spatie.be/products), we use our homegrown [Mailcoach](https://mailcoach.app). For HR, we use [Officient](https://www.officient.io). The entire team uses [Claude Code](https://claude.ai/code) as their coding agent.

## In closing

Every few years, I write a new version of this post. Here's [the 2022 version](https://freek.dev/2387-my-current-setup-2022-edition). If you have any questions on any of these apps and services, feel free to contact me [on X](https://x.com/freekmurze) or [on Bluesky](https://bsky.app/profile/freekmurze.bsky.social).
