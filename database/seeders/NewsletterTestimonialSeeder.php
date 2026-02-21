<?php

namespace Database\Seeders;

use App\Models\NewsletterTestimonial;
use Illuminate\Database\Seeder;

class NewsletterTestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['author_name' => 'Sarah Chen', 'author_title' => 'Senior Developer at Acme', 'text' => "Freek's newsletter is the one I actually read. Every issue has something I can use in my projects right away."],
            ['author_name' => 'Marcus Johnson', 'author_title' => 'CTO at LaunchPad', 'text' => 'Honest, practical, and no fluff. The best way to stay current with the Laravel ecosystem.'],
            ['author_name' => 'Emma Rodriguez', 'author_title' => 'Freelance Developer', 'text' => "I've discovered so many useful packages and techniques through this newsletter. It's like having a senior developer curate the best of Laravel for you."],
            ['author_name' => 'Tom Baker', 'author_title' => 'Lead Developer at Streamline', 'text' => 'One email a month, always worth the read. Freek shares real lessons from shipping production code, not just theory.'],
            ['author_name' => 'Lisa Park', 'author_title' => 'Full-stack Developer', 'text' => 'The AI and Laravel content is exactly what I need. Short, useful, and from someone who actually builds things.'],
            ['author_name' => "James O'Brien", 'author_title' => 'Software Architect', 'text' => 'Been subscribed for years. It consistently surfaces the most relevant content in the PHP and Laravel world.'],
            ['author_name' => 'Priya Sharma', 'author_title' => 'Backend Developer at Zenith', 'text' => 'Every issue gives me at least one thing to try. Freek has a knack for making complex topics approachable.'],
            ['author_name' => 'Daniel Kim', 'author_title' => 'Engineering Manager', 'text' => "I share this newsletter with my entire team. It's the most efficient way to keep everyone up to date on Laravel."],
            ['author_name' => 'Sophie Turner', 'author_title' => 'Developer Advocate', 'text' => "Freek's writing is clear, concise, and always backed by real experience. No hype, just substance."],
            ['author_name' => 'Raj Patel', 'author_title' => 'PHP Consultant', 'text' => 'The open source insights alone make this newsletter invaluable. I always learn something new about package design.'],
            ['author_name' => 'Anna Kowalski', 'author_title' => 'Tech Lead at Basecamp', 'text' => 'This is the newsletter I recommend to every developer who works with Laravel. Period.'],
            ['author_name' => 'Chris Moreno', 'author_title' => 'Indie Developer', 'text' => 'As a solo developer, this newsletter helps me stay connected to the broader Laravel community without spending hours on Twitter.'],
            ['author_name' => 'Fatima Al-Hassan', 'author_title' => 'Senior Engineer at Shopify', 'text' => 'The mix of practical tips and big-picture thinking is what sets this newsletter apart from the rest.'],
            ['author_name' => 'Liam O\'Connor', 'author_title' => 'DevOps Engineer', 'text' => "Even though I'm not a full-time PHP developer, I always find relevant takeaways in Freek's newsletter."],
            ['author_name' => 'Maria Santos', 'author_title' => 'Startup Founder', 'text' => "Freek's newsletter helped me make better technical decisions for my startup. It's honest and practical."],
            ['author_name' => 'Henrik Larsson', 'author_title' => 'Developer at Spotify', 'text' => 'Concise, well-written, and always relevant. One of the few newsletters that survived my inbox cleanup.'],
            ['author_name' => 'Olivia Wang', 'author_title' => 'Junior Developer', 'text' => 'As someone early in my career, this newsletter has been a goldmine for learning Laravel best practices.'],
            ['author_name' => 'Nathan Brooks', 'author_title' => 'Agency Owner', 'text' => 'My team builds Laravel apps for clients. This newsletter keeps us sharp and aware of the latest tools.'],
            ['author_name' => 'Yuki Tanaka', 'author_title' => 'Full-stack Developer', 'text' => 'The newsletter introduced me to packages that saved me weeks of work. Absolutely worth subscribing.'],
            ['author_name' => 'David Mueller', 'author_title' => 'Senior Developer at BMW', 'text' => 'Freek writes from experience. You can tell every tip comes from real projects, not just documentation.'],
            ['author_name' => 'Rachel Green', 'author_title' => 'Product Engineer', 'text' => 'Love the balance between code-level details and higher-level architecture discussions.'],
            ['author_name' => 'Ahmed Hassan', 'author_title' => 'Freelance Developer', 'text' => 'This is my go-to resource for staying current with PHP. Every issue is packed with value.'],
            ['author_name' => 'Ingrid Nilsen', 'author_title' => 'CTO at NordTech', 'text' => "I've been following Freek's work for years. The newsletter distills the best of his knowledge into one monthly email."],
            ['author_name' => 'Carlos Ruiz', 'author_title' => 'Platform Engineer', 'text' => 'The AI coverage has been excellent. Freek is one of the few PHP developers bridging the gap to modern AI tooling.'],
            ['author_name' => 'Jessica Liu', 'author_title' => 'Software Developer at Stripe', 'text' => 'Short, actionable, and well-curated. Exactly what a developer newsletter should be.'],
            ['author_name' => 'Patrick Murphy', 'author_title' => 'Senior Developer', 'text' => "I've tried many newsletters over the years. This one consistently delivers the most value per email."],
            ['author_name' => 'Aisha Okafor', 'author_title' => 'Backend Developer', 'text' => "Freek's newsletter helped me level up from junior to senior faster than any course I took."],
            ['author_name' => 'Mikael Berg', 'author_title' => 'Architect at Volvo', 'text' => 'Practical advice from someone who maintains 300+ packages. You cannot find a more credible source.'],
            ['author_name' => 'Laura Chen', 'author_title' => 'DevRel at DigitalOcean', 'text' => "I regularly share links from Freek's newsletter in our developer community. It sparks great discussions."],
            ['author_name' => 'Ben Thompson', 'author_title' => 'Independent Consultant', 'text' => "The best part is the honesty. Freek shares what works AND what doesn't, which is rare in tech newsletters."],
            ['author_name' => 'Nina Petrova', 'author_title' => 'Team Lead at JetBrains', 'text' => 'As someone working on developer tools, this newsletter gives me insight into what PHP developers actually need.'],
            ['author_name' => 'Oscar Fernandez', 'author_title' => 'Fullstack Developer', 'text' => "Every time I think about unsubscribing from newsletters, Freek's is the one that stays."],
            ['author_name' => 'Maya Jensen', 'author_title' => 'Developer at Maersk', 'text' => "I started using Spatie packages because of this newsletter. Now they're essential in every project."],
            ['author_name' => 'Ryan Walsh', 'author_title' => 'Engineering Lead', 'text' => 'A curated snapshot of the Laravel world, delivered monthly. No spam, no filler, just quality content.'],
            ['author_name' => 'Zara Hussain', 'author_title' => 'PHP Developer', 'text' => "I've learned more practical Laravel from this newsletter than from most online courses combined."],
            ['author_name' => 'Erik Svensson', 'author_title' => 'Senior Developer at Klarna', 'text' => 'The open source maintenance tips alone are worth the subscription. Freek really walks the talk.'],
            ['author_name' => 'Diana Popov', 'author_title' => 'CTO at CodeFirst', 'text' => "It's refreshing to read a newsletter that respects your time. Every paragraph earns its place."],
            ['author_name' => 'Sam Wilson', 'author_title' => 'Freelance Developer', 'text' => 'After reading this newsletter for a year, my code quality improved dramatically. Real patterns from real projects.'],
            ['author_name' => 'Leila Bouchard', 'author_title' => 'Developer at Ubisoft', 'text' => "Even in the gaming industry, Laravel skills are valuable. Freek's newsletter keeps mine sharp."],
            ['author_name' => 'Thomas Fischer', 'author_title' => 'Solution Architect', 'text' => 'I appreciate how the newsletter covers both bleeding-edge topics and fundamentals. Something for everyone.'],
            ['author_name' => 'Megan Clark', 'author_title' => 'Senior Engineer at Xero', 'text' => 'The testing advice in this newsletter has transformed how our team approaches quality assurance.'],
            ['author_name' => 'Ivan Volkov', 'author_title' => 'Backend Developer', 'text' => "Freek's take on building maintainable applications is invaluable. The newsletter reflects that philosophy."],
            ['author_name' => 'Julia Santos', 'author_title' => 'Tech Educator', 'text' => "I recommend this newsletter to all my students. It's a window into how professional Laravel development actually works."],
            ['author_name' => 'Alex Thornton', 'author_title' => 'DevOps at Atlassian', 'text' => 'Clean writing, practical advice, zero fluff. The newsletter every developer wishes they had found sooner.'],
            ['author_name' => 'Nadia Kovic', 'author_title' => 'Full-stack Developer', 'text' => "I've switched jobs twice and this newsletter was relevant every time. It transcends any single tech stack."],
            ['author_name' => 'Hugo Martin', 'author_title' => 'VP Engineering', 'text' => 'I forward this newsletter to my entire engineering org. The signal-to-noise ratio is unmatched.'],
            ['author_name' => 'Clara Hoffmann', 'author_title' => 'Developer at SAP', 'text' => 'Laravel, PHP, AI, open source — all covered with depth and clarity. My monthly must-read.'],
            ['author_name' => 'Jake Robinson', 'author_title' => 'Indie Maker', 'text' => 'This newsletter has directly influenced several features in my SaaS products. Practical gold.'],
            ['author_name' => 'Amira Nasser', 'author_title' => 'Software Engineer', 'text' => "The community aspect is what I love most. You feel like you're learning alongside thousands of other developers."],
            ['author_name' => 'Leo Virtanen', 'author_title' => 'Developer at Wolt', 'text' => "Freek's perspective on sustainable open source is unique and deeply informed. The newsletter reflects that depth."],
        ];

        foreach ($testimonials as $index => $testimonial) {
            NewsletterTestimonial::create([
                ...$testimonial,
                'avatar_url' => 'https://i.pravatar.cc/150?u=testimonial-'.$index,
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }
    }
}
