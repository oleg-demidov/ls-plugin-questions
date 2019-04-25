
{$items = []}
{foreach $aCategories as $category}
    {$items[] = [
        'text' => $category.entity->getTitle(),
        'url'  => {router page="questions/{$category.entity->getUrl()}"}
    ]}
{/foreach}

{component 'bs-card' 
    classes = "mt-2" 
    text    = "white" 
    content = [
        [
            type => 'header',
            content => "Категории"
        ],
        [   
            type => 'body',
            classes => 'p-1',
            content => {component "bs-nav"
                vertical    = true
                items       = $items
            }
        ]
]}
    
    
