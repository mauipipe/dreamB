Feature:
  In order to handle a beach
  As a api maintainer
  I should be able to add a beach to the db

  @beach
  Scenario:
    Given there are 0 'Beach' in the system
    When I send a POST request to "/beach" with values:
      | city_id | 1          |
      | name    | Boca Raton |
    Then the response code should be 201
    And there are 1 'Beach' in the system

