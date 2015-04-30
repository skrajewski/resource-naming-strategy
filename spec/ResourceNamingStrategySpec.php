<?php

namespace spec\Szykra\NamingStrategy;

use ICanBoogie\Inflections;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceNamingStrategySpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType("Szykra\NamingStrategy\ResourceNamingStrategy");
    }

    function it_return_table_name_from_simple_class_name()
    {
        $this->classToTableName("User")->shouldReturn("users");
        $this->classToTableName("Category")->shouldReturn("categories");
        $this->classToTableName("Person")->shouldReturn("people");
    }

    function it_return_table_name_from_advanced_class_name()
    {
        $this->classToTableName("UserActivity")->shouldReturn("user_activities");
        $this->classToTableName("AdvancedTechnology")->shouldReturn("advanced_technologies");
        $this->classToTableName("task_detail")->shouldReturn("task_details");
    }

    function it_return_Table_name_from_full_class_name()
    {
        $this->classToTableName("App\\Entities\\Car")->shouldReturn("cars");
    }

    function it_return_column_name_from_property_name()
    {
        $this->propertyToColumnName("firstName")->shouldReturn("first_name");
        $this->propertyToColumnName("last_name")->shouldReturn("last_name");
        $this->propertyToColumnName("roles")->shouldReturn("roles");
    }

    function it_return_column_name_for_embedded_property()
    {
        $this->embeddedFieldToColumnName("address", "street")->shouldReturn("address_street");
        $this->embeddedFieldToColumnName("address", "flatNo")->shouldReturn("address_flat_no");
        $this->embeddedFieldToColumnName("castData", "realName")->shouldReturn("cast_data_real_name");
        $this->embeddedFieldToColumnName("cast_data", "fake_name")->shouldReturn("cast_data_fake_name");
    }

    function it_return_reference_column_name()
    {
        $this->referenceColumnName()->shouldReturn("id");
    }

    function it_return_join_column_name_from_property_name()
    {
        $this->joinColumnName("user")->shouldReturn("user_id");
        $this->joinColumnName("taskActivity")->shouldReturn("task_activity_id");
    }

    function it_return_join_table_name_ascending()
    {
        $this->joinTableName("User", "Task")->shouldReturn("task_user");
        $this->joinTableName("Task", "TaskActivity")->shouldReturn("task_task_activity");
        $this->joinTableName("Home", "Person")->shouldReturn("home_person");
    }

    function it_return_join_key_column_name()
    {
        $this->joinKeyColumnName("User")->shouldReturn("user_id");
        $this->joinKeyColumnName("Reporter", "identity")->shouldReturn("reporter_identity");
    }

}
