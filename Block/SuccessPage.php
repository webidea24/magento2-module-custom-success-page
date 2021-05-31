<?php


namespace Webidea24\CustomSuccessPage\Block;


use Magento\Cms\Block\Block;
use Magento\Store\Model\ScopeInterface;

class SuccessPage extends \Magento\Checkout\Block\Onepage\Success
{

    public function getContent()
    {
        $blockId = $this->_scopeConfig->getValue('wi24_custom_success_page/general/static_block', ScopeInterface::SCOPE_STORE);
        if($blockId === null) {
            return '';
        }
        $order = $this->_checkoutSession->getLastRealOrder();
        $block = $this->_layout->createBlock(Block::class)->setData('block_id', $blockId);

        if ($this->getData('is_order_visible')) {
            $incrementId = sprintf('<a href="%s"><strong>%s</strong></a>', $block->escapeUrl($this->getData('view_order_url')), $order->getIncrementId());
        } else {
            $incrementId = $order->getIncrementId();
        }

        return str_replace([
            '%order-number%',
            '%additional-info-html%',
            '%registration-block%'
        ], [
            $incrementId,
            $this->getAdditionalInfoHtml(),
            $this->getChildHtml('checkout.registration')
        ],
            $block->toHtml() ?? ''
        );
    }

}
