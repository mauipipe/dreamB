Feature:
  In order to handle a beach
  As a api maintainer
  I should be able to add a beach to the db

  @wip @beach
  Scenario:
    Given there are 0 'Beach' in the system
    When I send a POST request to "/beaches" with values:
      | city_id | name       | slug       | coordinates        |
      | 1       | Boca Raton | boca-raton | {16.8900,78.90909) |
    Then the response code should be 201
    And I should have 1 'Beach' in my system

