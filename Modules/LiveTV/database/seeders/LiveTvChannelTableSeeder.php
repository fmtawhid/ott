<?php

namespace Modules\LiveTV\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Models\TvChannelStreamContentMapping;

class LiveTvChannelTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
        {
            Schema::disableForeignKeyConstraints();


            $avatarPath = config('app.avatar_base_path');

            $liveTvChannels = [
                [
                    'name' => 'Aaj Kal LIVE TV',
                    'poster_url' => '/dummy-images/livetv/channel/aaj_kal_live_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/aaj_kal_live_tv.png',
                    'category_id' => 1,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'description' => 'Stay informed with live news broadcasts and in-depth analysis on Aaj Kal LIVE TV. Never miss a moment of the latest updates from around the world.',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',  //t_embedded
                            'stream_type'=>'URL',
                            'embedded'=>Null,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1'=>Null,
                        ],
                    ]
                ],
                [
                    'name' => 'ABP Sports',
                    'poster_url' => '/dummy-images/livetv/channel/abp_sports.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/abp_sports.png',
                    'category_id' => 2,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 1,
                    'description' => 'Catch all the live sports action on ABP Sports, covering your favorite games and tournaments with expert commentary and thrilling highlights.',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type'=>'URL',
                            'embedded'=>Null,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1'=>Null,
                        ],
                    ]
                ],
                [
                    'name' => 'DN TV',
                    'poster_url' => '/dummy-images/livetv/channel/dn_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/dn_tv.png',
                    'category_id' => 3,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 2,
                    'description' => 'Enjoy a variety of entertainment shows on DN TV, featuring reality TV, talent competitions, talk shows, and award ceremonies.',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type'=>'URL',
                            'embedded'=>Null,
                            'server_url' => 'https://abplivetv.akamaized.net/hls/live/2043010/hindi/master.m3u8',
                            'server_url1'=>Null,
                        ],
                    ]
                ],
                [
                    'name' => '9xm',
                    'poster_url' => '/dummy-images/livetv/channel/9xm.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/9xm.png',
                    'category_id' => 4,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 3,
                    'description' => 'Music & Concerts channel featuring live performances and more.',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type'=>'URL',
                            'embedded'=>Null,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1'=>Null,
                        ],
                    ]
                ],
                [
                    'name' => 'BBP',
                    'poster_url' => '/dummy-images/livetv/channel/bbp.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/bbp.png',
                    'category_id' => 5,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 4,
                    'description' => 'Educational & Documentary channel with a wide range of informative content.',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type'=>'URL',
                            'embedded'=>Null,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1'=>Null,
                        ],
                    ]
                ],
                [
                    'name' => 'M TV',
                    'poster_url' => '/dummy-images/livetv/channel/m_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/m_tv.png',
                    'category_id' => 4,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'description' => 'Free Music & Concerts channel with live performances and more.',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type'=>'URL',
                            'embedded'=>Null,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1'=>Null,
                        ],
                    ]
                ],
                [
                    'name' => 'ZNews 24/7',
                    'poster_url' => '/dummy-images/livetv/channel/znews_247.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/znews_247.png',
                    'category_id' => 1,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Round-the-clock coverage of global news and current events to keep you informed all day. 🌍🕓',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Sports Max',
                    'poster_url' => '/dummy-images/livetv/channel/sports_max.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/sports_max.png',
                    'category_id' => 2,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 1,
                    'description' => 'The ultimate channel for live sports events, from football to cricket, with non-stop action. 🏆📢',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Vibe TV',
                    'poster_url' => '/dummy-images/livetv/channel/vibe_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/vibe_tv.png',
                    'category_id' => 3,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 2,
                    'description' => 'The hottest variety of live entertainment, from reality shows to talk shows and much more. 🎭🔥',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Beat Box',
                    'poster_url' => '/dummy-images/livetv/channel/beat_box.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/beat_box.png',
                    'category_id' => 4,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Feel the beat with live music performances, DJ sets, and non-stop tunes. 🎧🎵',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Brain TV',
                    'poster_url' => '/dummy-images/livetv/channel/brain_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/brain_tv.png',
                    'category_id' => 5,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 4,
                    'description' => 'Dive into a world of learning with live educational shows and insightful documentaries. 🧠📺',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Khabar NOW',
                    'poster_url' => '/dummy-images/livetv/channel/khabar_now.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/khabar_now.png',
                    'category_id' => 1,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 2,
                    'description' => 'Instant access to real-time news and headlines that matter most, bringing the world to your screen. 📰📢',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Goal TV',
                    'poster_url' => '/dummy-images/livetv/channel/goal_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/goal_tv.png',
                    'category_id' => 2,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Your destination for all things football, with live coverage of matches, interviews, and goals. ⚽🎥',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Star Bliss',
                    'poster_url' => '/dummy-images/livetv/channel/star_bliss.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/star_bliss.png',
                    'category_id' => 3,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Bringing you a star-studded lineup of live entertainment, talk shows, and celebrity interviews. ⭐🎬',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Groove LIVE',
                    'poster_url' => '/dummy-images/livetv/channel/groove_live.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/groove_live.png',
                    'category_id' => 4,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Get into the groove with live music shows, concerts, and your favorite artists. 🎼🎸',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Docu Vision',
                    'poster_url' => '/dummy-images/livetv/channel/docu_vision.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/docu_vision.png',
                    'category_id' => 5,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 4,
                    'description' => 'Explore fascinating live documentaries on a range of topics, from history to science. 📚🎬',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Vision TV',
                    'poster_url' => '/dummy-images/livetv/channel/vision_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/vision_tv.png',
                    'category_id' => 1,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Sharp and focused news, providing clear insights into the events shaping the world today. 🔍📺',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Win Sports',
                    'poster_url' => '/dummy-images/livetv/channel/win_sports.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/win_sports.png',
                    'category_id' => 2,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 1,
                    'description' => 'Bringing the winning moments from the biggest sporting events, straight to your screen, live. 🎖️📺',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Buzz LIVE',
                    'poster_url' => '/dummy-images/livetv/channel/buzz_live.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/buzz_live.png',
                    'category_id' => 3,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'All the buzzworthy content in one place, from live interviews to fun, energetic shows. 🎤⚡',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Tune IN',
                    'poster_url' => '/dummy-images/livetv/channel/tune_in.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/tune_in.png',
                    'category_id' => 4,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 3,
                    'description' => 'Stay tuned to the latest live music performances and the freshest beats from top artists. 🎙️📻',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'DiscoverX',
                    'poster_url' => '/dummy-images/livetv/channel/discoverx.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/discoverx.png',
                    'category_id' => 5,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 4,
                    'description' => 'Uncover the unknown with live explorations and educational content from around the globe. 🌍🔎',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'HeadlineX',
                    'poster_url' => '/dummy-images/livetv/channel/headlinex.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/headlinex.png',
                    'category_id' => 1,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Your go-to for breaking headlines and live updates, keeping you in the know. 🗞️🎯',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Xtreme Sports',
                    'poster_url' => '/dummy-images/livetv/channel/xtreme_sports.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/xtreme_sports.png',
                    'category_id' => 2,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 2,
                    'description' => 'Tune in for adrenaline-pumping sports events, from extreme sports to intense competition. 🏄‍♂️🔥',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Fun Box',
                    'poster_url' => '/dummy-images/livetv/channel/fun_box.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/fun_box.png',
                    'category_id' => 3,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'A playful mix of live comedy, gameshows, and entertainment to keep you laughing. 🤣📺',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Sound Wave',
                    'poster_url' => '/dummy-images/livetv/channel/sound_wave.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/sound_wave.png',
                    'category_id' => 4,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 2,
                    'description' => 'Feel the pulse of live music as you experience concerts and performances from the world’s best artists. 🎤🌊',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Learn LIVE',
                    'poster_url' => '/dummy-images/livetv/channel/learn_live.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/learn_live.png',
                    'category_id' => 5,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 4,
                    'description' => 'Interactive educational programming, live lectures, and documentaries to spark your curiosity. 🎓📡',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Live Line',
                    'poster_url' => '/dummy-images/livetv/channel/live_line.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/live_line.png',
                    'category_id' => 1,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Breaking news, live updates, and in-depth analysis at the speed of live broadcast. 📡⚡',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Pro Play',
                    'poster_url' => '/dummy-images/livetv/channel/pro_play.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/pro_play.png',
                    'category_id' => 2,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 3,
                    'description' => 'Watch your favorite athletes and teams go head-to-head in thrilling live action. 🏅🎬',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Show MAX',
                    'poster_url' => '/dummy-images/livetv/channel/show_max.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/show_max.png',
                    'category_id' => 3,
                    'thumb_url' => NULL,
                    'access' => 'paid',
                    'plan_id' => 2,
                    'description' => 'Maximize your entertainment with live shows, contests, and endless variety! 🎭💫',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'RhythmX',
                    'poster_url' => '/dummy-images/livetv/channel/rhythmx.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/rhythmx.png',
                    'category_id' => 4,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Tune in for live performances, chart-topping hits, and music from around the world. 🎶🎧',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
                [
                    'name' => 'Insight TV',
                    'poster_url' => '/dummy-images/livetv/channel/insight_tv.png',
                    'poster_tv_url' => '/dummy-images/livetv/channel/insight_tv.png',
                    'category_id' => 5,
                    'thumb_url' => NULL,
                    'access' => 'free',
                    'plan_id' => NULL,
                    'description' => 'Dive deep into thought-provoking live content that educates and inspires, from documentaries to expert talks. 📘🔍',
                    'status' => 1,
                    'stream_content_mappings' => [
                        [
                            'type' => 't_url',
                            'stream_type' => 'URL',
                            'embedded' => NULL,
                            'server_url' => 'https://feeds.intoday.in/aajtak/api/aajtakhd/master.m3u8',
                            'server_url1' => NULL,
                        ],
                    ],
                ],
            ];

                foreach ($liveTvChannels as $key => $liveTvChannel_data) {
                    $featureImage = $liveTvChannel_data['poster_url'] ?? null;
                    $posterTvImage = $liveTvChannel_data['poster_tv_url'] ?? null;
                    $channelData = Arr::except($liveTvChannel_data, ['poster_url','poster_tv_url','stream_content_mappings']);
                    $channel = LiveTvChannel::create($channelData);
                    if (isset($featureImage)) {
                        $originalUrl = $this->uploadToSpaces($featureImage);

                        if ($originalUrl) {
                            $channel->poster_url = extractFileNameFromUrl($originalUrl);
                            $channel->save();
                        }
                    }
                    if (isset($posterTvImage)) {
                        $posterTvUrl = $this->uploadToSpaces($posterTvImage);

                        if ($posterTvUrl) {
                            $channel->poster_tv_url = extractFileNameFromUrl($posterTvUrl);
                            $channel->save();
                        }
                    }
                    foreach ($liveTvChannel_data['stream_content_mappings'] as $mapping) {
                        TvChannelStreamContentMapping::create([
                            'tv_channel_id' => $channel->id,
                            'type' => $mapping['type'],
                            'stream_type' => $mapping['stream_type'],
                            'embedded' => $mapping['embedded'],
                            'server_url' => $mapping['server_url'],
                            'server_url1' => $mapping['server_url1'],
                        ]);
                    }
                }

                Schema::enableForeignKeyConstraints();

    }

    private function uploadToSpaces($publicPath)
    {
        $localFilePath = public_path($publicPath);
        $remoteFilePath = 'streamit-laravel/' . basename($publicPath);

        if (file_exists($localFilePath)) {
            // Get the active storage disk from the environment
            $disk = env('ACTIVE_STORAGE', 'local');

            if ($disk === 'local') {
                // Store in the public directory for local storage
                Storage::disk($disk)->put('public/' . $remoteFilePath, file_get_contents($localFilePath));
                return asset('storage/' . $remoteFilePath);
            } else {
                // Upload to the specified storage disk
                Storage::disk($disk)->put($remoteFilePath, file_get_contents($localFilePath));
                return Storage::disk($disk)->url($remoteFilePath);
            }
        }

        return false;
    }
}
