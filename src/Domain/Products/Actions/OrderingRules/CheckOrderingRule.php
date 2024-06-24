<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Accounts\Models\Account;
use Domain\Products\Exceptions\FailedOrderRuleCheck;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Support\Contracts\AbstractAction;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Enums\MatchAllAnyString;
use Support\Traits\ActionExecuteReturnsStatic;
use Support\Traits\HasExceptionCollection;

class CheckOrderingRule
    extends AbstractAction
    implements CanReceiveExceptionCollection
{
    use HasExceptionCollection,
        ActionExecuteReturnsStatic;

    private bool $passed = false;

    public function __construct(
        private OrderingRule $rule,
        private ?Account     $account
    )
    {
    }

    public function execute(): static
    {
        if (!$this->checkSubRulesAndConditions()) {
            return $this;
        }

        $this->passed = true;

        return $this;
    }

    public function throwIfFailed()
    {
        if (!$this->passed) {
            throw new FailedOrderRuleCheck(
                __("Failed to meet criteria for ordering: \n:errors", [
                    'errors' => $this->exceptionsToPlainText(),
                ])
            );
        }
    }

    private function checkSubRulesAndConditions(): bool
    {
        if ($this->rule->any_all === MatchAllAnyString::ANY) {
            return $this->checkSubRules() === true
                || $this->checkConditions() === true;
        }

        return $this->checkSubRules() === true
            && $this->checkConditions() === true;
    }

    private function checkSubRules(): ?bool
    {
        if (!$this->rule->hasSubRules()) {
            return null;
        }

        return CheckOrderingSubRules::run(
            $this->rule,
            $this->account,
        )
            ->transferExceptionsTo($this)
            ->result();
    }

    private function checkConditions(): bool
    {
        if (!$this->rule->hasConditions()) {
            return true;
        }

        return CheckOrderingRuleConditions::run(
            $this->rule,
            $this->account
        )
            ->transferExceptionsTo($this)
            ->result();
    }

//    private function checkRequiredSpecialtiesAny(): static
//    {
//        if (count($this->required_specialties_any)) {
//            $this->required_specialties_any = array_unique($this->required_specialties_any);
//            if (!$this->customer->isLoggedIn()) {
//                if (count($this->required_specialties_any) > 1) {
//                    $this->c_err(sprintf(_t($this->_t("loggedin_approved_specialties")), _t("any"), implode(", ", $this->required_specialties_any)));
//                } else {
//                    $this->c_err(sprintf(_t($this->_t("loggedin_approved_specialty")), implode("", $this->required_specialties_any)));
//                }
//            } else {
//                if (count($this->required_specialties_any) > 1) {
//                    $this->c_err(sprintf(_t($this->_t("approved_specialties")), _t("any"), implode(", ", $this->required_specialties_any)));
//                } else {
//                    $this->c_err(sprintf(_t($this->_t("approved_specialty")), implode("", $this->required_specialties_any)));
//                }
//            }
//        }
//    }
//
//    private function checkRequiredSpecialtiesAll(): static
//    {
//        if (count($this->required_specialties_all)) {
//            $this->required_specialties_all = array_unique($this->required_specialties_all);
//            if (!$this->customer->isLoggedIn()) {
//                if (count($this->required_specialties_all) > 1) {
//                    $this->c_err(sprintf(_t($this->_t("loggedin_approved_specialties")), _t("all"), implode(", ", $this->required_specialties_all)));
//                } else {
//                    $this->c_err(sprintf(_t($this->_t("loggedin_approved_specialty")), implode("", $this->required_specialties_all)));
//                }
//            } else {
//                if (count($this->required_specialties_any) > 1) {
//                    $this->c_err(sprintf(_t($this->_t("approved_specialties")), _t("all"), implode(", ", $this->required_specialties_any)));
//                } else {
//                    $this->c_err(sprintf(_t($this->_t("approved_specialty")), implode("", $this->required_specialties_any)));
//                }
//            }
//        }
//    }
//
//    private function checkRequiredAccountType(): static
//    {
//        if (count($this->required_account_types)) {
//            $this->required_account_types = array_unique($this->required_account_types);
//
//            if (!$this->customer->isLoggedIn()) {
//                if (count($this->required_account_types) > 1) {
//                    $this->c_err(sprintf(_t($this->_t("loggedin_account_types")), implode(", ", $this->required_account_types)));
//                } else {
//                    $this->c_err(sprintf(_t($this->_t("loggedin_account_type")), implode("", $this->required_account_types)));
//                }
//            } else {
//                if (count($this->required_account_types) > 1) {
//                    $this->c_err(sprintf(_t($this->_t("required_account_types")), implode(", ", $this->required_account_types)));
//                } else {
//                    $this->c_err(sprintf(_t($this->_t("required_account_type")), implode("", $this->required_account_types)));
//                }
//            }
//        }
//    }
//
//    private function checkRequiredAccount(): static
//    {
//        if ($this->required_account) {
//            $this->c_err(_t("You must be logged into an account to order this item"));
//        }
//
//        return $this;
//    }
}

/*
 *
 *
        function loadChildRules($id=false){
            $q = new BuildSelect("SELECT c.id, c.child_rule_id, o.name
FROM `products-rules-ordering_rules` c JOIN `products-rules-ordering` o ON o.id=c.child_rule_id");
            $q->addWhere("c.parent_rule_id", $this->id);
            if($id) $q->addWhere("c.id", $id);
            $this->child_rules = new Query($q, "child rules");
            if($this->child_rules->getTotal() > 0) return true;
            else return false;
        }

        function hasChildRules(){
            return (count($this->children) > 0) ? true:false;
            //return ($this->child_rules->getTotal() > 0) ? true:false;
        }

        function checkChildRules(){
            if($this->hasChildRules()){
                if($this->debug) echo $this->id.'->'.'has child rules<br>';
                $result = true;
                foreach($this->children as $child_rule){//foreach($this->child_rules->results as $r){
                    if($this->debug) echo $this->id.'->checking child '.$child_rule->get('id')."<br>";
                    if(!$child_rule->check()){
                        $result = false;

                        if(count($child_rule->required_specialties_any)){
                            $this->required_specialties_any = array_merge($this->required_specialties_any, $child_rule->required_specialties_any);
                        }
                        if(count($child_rule->required_specialties_all)){
                            $this->required_specialties_all = array_merge($this->required_specialties_all, $child_rule->required_specialties_all);
                        }
                        if(count($child_rule->required_account_types)){
                            $this->required_account_types = array_merge($this->required_account_types, $child_rule->required_account_types);
                        }
                        if($child_rule->required_account) $this->required_account = true;

                        $child_rule->c_transferErrorsTo($this);
                    }
                }
                return $result;
            }else if($this->debug) echo $this->id.'->'.'has no child rules<br>';
            return true;
        }
 */
